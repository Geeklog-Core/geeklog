<?php

$_SQL[] = "
CREATE TABLE {$_TABLES['access']} (
  acc_ft_id smallint NOT NULL default '0',
  acc_grp_id smallint NOT NULL default '0',
  PRIMARY KEY (acc_ft_id,acc_grp_id)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['article_images']} (
  ai_sid varchar(128) NOT NULL,
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
  blockorder smallint NOT NULL default '1',
  device varchar(15) NOT NULL default 'all',
  content text,
  allow_autotags smallint NOT NULL DEFAULT '0',
  convert_newlines smallint NOT NULL DEFAULT '0',
  cache_time INT NOT NULL DEFAULT '0',
  rdfurl varchar(255) default NULL,
  rdfupdated timestamp  default NULL,
  rdf_last_modified varchar(40) default NULL,
  rdf_etag varchar(40) default NULL,
  rdflimit smallint NOT NULL default '0',
  onleft smallint NOT NULL default '1',
  location varchar(48) NOT NULL default '',
  phpblockfn varchar(128) default '',
  help varchar(255) default '',
  css_id varchar(255) NOT NULL default '',
  css_classes varchar(255) NOT NULL default '',
  owner_id smallint NOT NULL default '1',
  group_id smallint NOT NULL default '1',
  perm_owner smallint NOT NULL default '3',
  perm_group smallint NOT NULL default '3',
  perm_members smallint NOT NULL default '2',
  perm_anon smallint NOT NULL default '2',
  PRIMARY KEY (bid)
);
  CREATE INDEX {$_TABLES['blocks']}_bid ON {$_TABLES['blocks']}(bid);
  CREATE INDEX {$_TABLES['blocks']}_is_enabled ON {$_TABLES['blocks']}(is_enabled);
  CREATE INDEX {$_TABLES['blocks']}_type ON {$_TABLES['blocks']}(type);
  CREATE INDEX {$_TABLES['blocks']}_name ON {$_TABLES['blocks']}(name);
  CREATE INDEX {$_TABLES['blocks']}_onleft ON {$_TABLES['blocks']}(onleft);
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
CREATE TABLE {$_TABLES['commentnotifications']} (
  cid int default NULL,
  uid smallint NOT NULL,
  deletehash varchar(32) NOT NULL,
  mid int default NULL,
  PRIMARY KEY (deletehash)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['comments']} (
  cid SERIAL,
  type varchar(30) NOT NULL DEFAULT 'article',
  sid varchar(128) NOT NULL default '',
  date timestamp NOT NULL DEFAULT current_timestamp,
  title varchar(128) default NULL,
  comment text,
  pid int NOT NULL default '0',
  lft smallint NOT NULL default '0',
  rht smallint NOT NULL default '0',
  indent smallint NOT NULL default '0',
  name varchar(32) default NULL,
  uid smallint NOT NULL default '1',
  seq INT NOT NULL DEFAULT 0,
  PRIMARY KEY (cid)
);
  CREATE INDEX {$_TABLES['comments']}_sid ON {$_TABLES['comments']}(sid);
  CREATE INDEX {$_TABLES['comments']}_uid ON {$_TABLES['comments']}(uid);
  CREATE INDEX {$_TABLES['comments']}_lft ON {$_TABLES['comments']}(lft);
  CREATE INDEX {$_TABLES['comments']}_rht ON {$_TABLES['comments']}(rht);
  CREATE INDEX {$_TABLES['comments']}_date ON {$_TABLES['comments']}(date);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['commentsubmissions']} (
  cid SERIAL,
  type varchar(30) NOT NULL default 'article',
  sid varchar(128) NOT NULL,
  date timestamp NOT NULL default current_timestamp,
  title varchar(128) default NULL,
  comment text,
  uid smallint NOT NULL default '1',
  name varchar(32) default NULL,
  pid int NOT NULL default '0',
  seq INT NOT NULL DEFAULT 0,
  PRIMARY KEY (cid)
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
  tab int default NULL,
  fieldset int default NULL
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['features']} (
  ft_id SERIAL ,
  ft_name varchar(50) NOT NULL default '',
  ft_descr varchar(255) NOT NULL default '',
  ft_gl_core smallint NOT NULL default '0',
  PRIMARY KEY (ft_id)
);
  CREATE INDEX {$_TABLES['features']}_ft_name ON {$_TABLES['features']}(ft_name);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['group_assignments']} (
  ug_main_grp_id smallint NOT NULL default '0',
  ug_uid smallint  default NULL,
  ug_grp_id smallint  default NULL
);
  CREATE INDEX {$_TABLES['group_assignments']}_ug_main_grp_id ON {$_TABLES['group_assignments']}(ug_main_grp_id);
  CREATE INDEX {$_TABLES['group_assignments']}_ug_uid ON {$_TABLES['group_assignments']}(ug_uid);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['groups']} (
  grp_id SERIAL,
  grp_name varchar(50) NOT NULL default '',
  grp_descr varchar(255) NOT NULL default '',
  grp_gl_core smallint NOT NULL default '0',
  grp_default smallint NOT NULL default '0',
  PRIMARY KEY (grp_id)
);
  CREATE UNIQUE INDEX {$_TABLES['groups']}_grp_name ON {$_TABLES['groups']}(grp_name);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['ip_addresses']} (
  seq SERIAL,
  ipaddress VARCHAR(39) NOT NULL DEFAULT '0.0.0.0',
  created_at INT NOT NULL DEFAULT 0,
  is_anonymized INT NOT NULL default 0,
  PRIMARY KEY (seq)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['language_items']} (
  id SERIAL NOT NULL,
  var_name varchar(30) NOT NULL,
  language varchar(30) NOT NULL,
  name varchar(30) NOT NULL,
  value text,
  PRIMARY KEY (id)
)
";

$_SQL[] ="
CREATE TABLE {$_TABLES['likes']} (
  lid SERIAL NOT NULL,
  type varchar(30) NOT NULL,
  subtype varchar(15) NOT NULL DEFAULT '',
  id varchar(128) NOT NULL,
  uid smallint NOT NULL,
  seq INT NOT NULL DEFAULT 0,
  action smallint NOT NULL,
  created timestamp NOT NULL,
  PRIMARY KEY (lid)
);
CREATE INDEX {$_TABLES['likes']}_type ON {$_TABLES['likes']} (type,subtype,id);
CREATE INDEX {$_TABLES['likes']}type_2 ON {$_TABLES['likes']} (type,id);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['pingservice']} (
  pid SERIAL,
  name varchar(128) default NULL,
  ping_url varchar(255) default NULL,
  site_url varchar(255) default NULL,
  method varchar(80) default NULL,
  is_enabled smallint NOT NULL DEFAULT '1',
  PRIMARY KEY (pid)
);
  CREATE INDEX {$_TABLES['pingservice']}_is_enabled ON {$_TABLES['pingservice']}(is_enabled);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['plugins']} (
  pi_name varchar(30) NOT NULL default '',
  pi_version varchar(20) NOT NULL default '',
  pi_gl_version varchar(20) NOT NULL default '',
  pi_enabled smallint NOT NULL default '1',
  pi_homepage varchar(128) NOT NULL default '',
  pi_load smallint NOT NULL default '10000',
  PRIMARY KEY (pi_name)
  );
  CREATE INDEX {$_TABLES['plugins']}_enabled ON {$_TABLES['plugins']}(pi_enabled);
";

$_SQL[] = "CREATE TABLE {$_TABLES['routes']} (
    rid SERIAL,
    method int NOT NULL DEFAULT 1,
    rule varchar(255) NOT NULL DEFAULT '',
    route varchar(255) NOT NULL DEFAULT '',
    status_code int NOT NULL DEFAULT 200,
    priority int NOT NULL DEFAULT 100,
    enabled smallint NOT NULL default '1',
    PRIMARY KEY (rid)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['sessions']} (
  sess_id VARCHAR(190) NOT NULL default '',
  start_time int NOT NULL default '0',
  seq INT NOT NULL default 0,
  uid smallint NOT NULL default '1',
  whos_online smallint NOT NULL default '1',
  autologin_key_hash VARCHAR(190) NOT NULL DEFAULT '',
  PRIMARY KEY (sess_id)
);
  CREATE INDEX {$_TABLES['sessions']}_start_time ON {$_TABLES['sessions']} (start_time);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['speedlimit']} (
  id SERIAL,
  ipaddress varchar(39) NOT NULL default '',
  date int default NULL,
  type varchar(30) NOT NULL default 'submit',
  PRIMARY KEY (id)
);
  CREATE UNIQUE INDEX {$_TABLES['speedlimit']}_type_ipaddress ON {$_TABLES['speedlimit']}(type,ipaddress);
  CREATE UNIQUE INDEX {$_TABLES['speedlimit']}_date ON {$_TABLES['speedlimit']}(date);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['stories']} (
  sid varchar(128) NOT NULL default '',
  uid smallint NOT NULL default '1',
  draft_flag smallint default '0',
  date timestamp NOT NULL default current_timestamp,
  modified timestamp default NULL,
  title varchar(128) default NULL,
  page_title varchar(128) default NULL,
  introtext text,
  bodytext text,
  text_version smallint NOT NULL default '1',
  hits smallint NOT NULL default '0',
  numpages smallint NOT NULL DEFAULT '1',
  numemails smallint NOT NULL default '0',
  comments smallint NOT NULL default '0',
  comment_expire timestamp default NULL,
  trackbacks smallint NOT NULL default '0',
  related text,
  featured smallint NOT NULL default '0',
  show_topic_icon smallint NOT NULL default '1',
  commentcode smallint NOT NULL default '0',
  structured_data_type varchar(40) NOT NULL DEFAULT '',
  trackbackcode smallint NOT NULL default '0',
  statuscode smallint NOT NULL default '0',
  expire timestamp default NULL,
  postmode varchar(10) NOT NULL default 'html',
  advanced_editor_mode smallint  default '0',
  frontpage smallint default '1',
  meta_description TEXT NULL,
  meta_keywords TEXT NULL,
  cache_time INT NOT NULL DEFAULT '0',
  owner_id smallint NOT NULL default '1',
  group_id smallint NOT NULL default '2',
  perm_owner smallint NOT NULL default '3',
  perm_group smallint NOT NULL default '3',
  perm_members smallint NOT NULL default '2',
  perm_anon smallint NOT NULL default '2',
  PRIMARY KEY (sid)
);
  CREATE INDEX {$_TABLES['stories']}_sid ON {$_TABLES['stories']}(sid);
  CREATE INDEX {$_TABLES['stories']}_uid ON {$_TABLES['stories']}(uid);
  CREATE INDEX {$_TABLES['stories']}_featured ON {$_TABLES['stories']}(featured);
  CREATE INDEX {$_TABLES['stories']}_hits ON {$_TABLES['stories']}(hits);
  CREATE INDEX {$_TABLES['stories']}_statuscode ON {$_TABLES['stories']}(statuscode);
  CREATE INDEX {$_TABLES['stories']}_expire ON {$_TABLES['stories']}(expire);
  CREATE INDEX {$_TABLES['stories']}_date ON {$_TABLES['stories']}(date);
  CREATE INDEX {$_TABLES['stories']}_frontpage ON {$_TABLES['stories']}(frontpage);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['storysubmission']} (
  sid varchar(20) NOT NULL default '',
  uid smallint NOT NULL default '1',
  title varchar(128) default NULL,
  introtext text,
  bodytext text,
  text_version smallint NOT NULL default '1',
  date timestamp default NULL,
  postmode varchar(10) NOT NULL default 'html',
  meta_description TEXT NULL,
  meta_keywords TEXT NULL,
  PRIMARY KEY (sid)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['syndication']} (
  fid SERIAL,
  type varchar(30) NOT NULL default 'article',
  topic varchar(75) NOT NULL default '::all',
  header_tid varchar(75) NOT NULL default 'none',
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
  CREATE INDEX {$_TABLES['syndication']}_type ON {$_TABLES['syndication']}(type);
  CREATE INDEX {$_TABLES['syndication']}_topic ON {$_TABLES['syndication']}(topic);
  CREATE INDEX {$_TABLES['syndication']}_is_enabled ON {$_TABLES['syndication']}(is_enabled);
  CREATE INDEX {$_TABLES['syndication']}_updated ON {$_TABLES['syndication']}(updated);
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

// Note: Subtype kept at 15 chars as max key length is approaching 1000 bytes for the primary key (for our minimum MySQL server requirements)
// Other Keys needed to speed up SQL for items that do not use subtype
$_SQL[] = "
CREATE TABLE {$_TABLES['topic_assignments']} (
  tid varchar(75) NOT NULL,
  type varchar(30) NOT NULL,
  subtype varchar(15) NOT NULL DEFAULT '',
  id varchar(128) NOT NULL,
  inherit smallint NOT NULL default '1',
  tdefault smallint NOT NULL default '0',
  PRIMARY KEY (tid,type,subtype,id)
);
CREATE INDEX {$_TABLES['topic_assignments']}_tid ON {$_TABLES['topic_assignments']}(tid, type, id);
CREATE INDEX {$_TABLES['topic_assignments']}_type ON {$_TABLES['topic_assignments']}(type, subtype, id);
CREATE INDEX {$_TABLES['topic_assignments']}_type_2 ON {$_TABLES['topic_assignments']}(type, id);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['topics']} (
  tid varchar(75) NOT NULL default '',
  topic varchar(75) default NULL,
  title varchar(128) default NULL,
  imageurl varchar(255) default NULL,
  meta_description TEXT NULL,
  meta_keywords TEXT NULL,
  sortnum smallint default NULL,
  limitnews smallint default NULL,
  is_default smallint NOT NULL DEFAULT '0',
  archive_flag smallint NOT NULL DEFAULT '0',
  parent_id varchar(128) NOT NULL default 'root',
  inherit smallint NOT NULL default '1',
  hidden smallint NOT NULL default '0',
  owner_id smallint NOT NULL default '1',
  group_id smallint NOT NULL default '1',
  perm_owner smallint NOT NULL default '3',
  perm_group smallint NOT NULL default '3',
  perm_members smallint NOT NULL default '2',
  perm_anon smallint NOT NULL default '2',
  PRIMARY KEY (tid)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['trackback']} (
  cid SERIAL,
  sid varchar(128) NOT NULL,
  url varchar(255) default NULL,
  title varchar(128) default NULL,
  blog varchar(80) default NULL,
  excerpt text,
  date timestamp default NULL,
  type varchar(30) NOT NULL default 'article',
  seq INT NOT NULL DEFAULT 0,
  PRIMARY KEY (cid)
);
  CREATE INDEX {$_TABLES['trackback']}_sid ON {$_TABLES['trackback']}(sid);
  CREATE INDEX {$_TABLES['trackback']}_url ON {$_TABLES['trackback']}(url);
  CREATE INDEX {$_TABLES['trackback']}_type ON {$_TABLES['trackback']}(type);
  CREATE INDEX {$_TABLES['trackback']}_date ON {$_TABLES['trackback']}(date);
";

// Since Geeklog-2.2.2, $_TABLES['usercomment'], $_TABLES['userindex'], $_TABLES['userinfo'], and $_TABLES['userprefs']
// tables are combined into $_TABLES['user_attributes'] table.
$_SQL[] = "
CREATE TABLE {$_TABLES['user_attributes']} (
  uid SMALLINT NOT NULL DEFAULT 1,
  commentmode VARCHAR(10) NOT NULL DEFAULT 'nested',
  commentorder VARCHAR(4) NOT NULL DEFAULT 'ASC',
  commentlimit SMALLINT NOT NULL DEFAULT 100,
  etids TEXT NOT NULL,
  noboxes SMALLINT NOT NULL DEFAULT 0,
  maxstories SMALLINT NOT NULL DEFAULT 0,
  about TEXT NOT NULL,
  location VARCHAR(96) NOT NULL DEFAULT '',
  pgpkey TEXT NOT NULL,
  tokens SMALLINT NOT NULL DEFAULT 0,
  lastgranted SMALLINT NOT NULL DEFAULT 0,
  lastlogin VARCHAR(10) NOT NULL DEFAULT '0',
  dfid SMALLINT NOT NULL DEFAULT 0,
  advanced_editor SMALLINT NOT NULL DEFAULT 1,
  tzid VARCHAR(125) NOT NULL DEFAULT '',
  emailfromadmin SMALLINT NOT NULL DEFAULT 1,
  emailfromuser SMALLINT NOT NULL DEFAULT 1,
  showonline SMALLINT NOT NULL DEFAULT 1,
  PRIMARY KEY (uid)
);";

$_SQL[] = "
CREATE TABLE {$_TABLES['userautologin']} (
  autologin_key_hash VARCHAR(190) NOT NULL DEFAULT '',
  expiry_time int NOT NULL default '0',
  uid smallint NOT NULL default '1',
  PRIMARY KEY (autologin_key_hash)
);
  CREATE INDEX {$_TABLES['userautologin']}_expiry_time ON {$_TABLES['userautologin']} (expiry_time);
  CREATE INDEX {$_TABLES['userautologin']}_uid ON {$_TABLES['userautologin']}(uid);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['users']} (
  uid SERIAL,
  username varchar(16) NOT NULL default '',
  remoteusername varchar(60) NULL,
  remoteservice varchar(60) NULL,
  fullname varchar(80) default NULL,
  passwd varchar(128) NOT NULL default '',
  salt varchar(64) NOT NULL default '',
  algorithm varchar(12) NOT NULL default 0,
  stretch int NOT NULL default 1,
  email varchar(96) default NULL,
  homepage varchar(96) default NULL,
  sig varchar(160) NOT NULL default '',
  regdate timestamp NOT NULL default current_timestamp ,
  photo varchar(128) DEFAULT NULL,
  cookietimeout int default 28800,
  theme varchar(64) default NULL,
  language varchar(64) default NULL,
  pwrequestid varchar(16) default NULL,
  emailconfirmid varchar(16) default NULL,
  emailtoconfirm varchar(96) default NULL,
  status smallint NOT NULL default 1,
  num_reminders smallint NOT NULL default 0,
  invalidlogins SMALLINT NOT NULL DEFAULT 0,
  lastinvalid int default NULL,
  twofactorauth_enabled SMALLINT NOT NULL DEFAULT 0,
  twofactorauth_secret VARCHAR(255) NOT NULL DEFAULT '',
  postmode VARCHAR (10) NOT NULL DEFAULT 'plaintext',
  PRIMARY KEY (uid)
);
  CREATE INDEX {$_TABLES['users']}_LOGIN ON {$_TABLES['users']}(uid,passwd,username);
  CREATE UNIQUE INDEX {$_TABLES['users']}_username ON {$_TABLES['users']}(username);
  CREATE INDEX {$_TABLES['users']}_fullname ON {$_TABLES['users']}(fullname);
  CREATE INDEX {$_TABLES['users']}_email ON {$_TABLES['users']}(email);
  CREATE INDEX {$_TABLES['users']}_passwd ON {$_TABLES['users']}(passwd);
  CREATE INDEX {$_TABLES['users']}_pwrequestid ON {$_TABLES['users']}(pwrequestid);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['vars']} (
  name varchar(20) NOT NULL default '',
  value TEXT default NULL,
  PRIMARY KEY (name)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['backup_codes']} (
  code VARCHAR(16) NOT NULL UNIQUE,
  uid INT NOT NULL DEFAULT 0,
  is_used SMALLINT NOT NULL DEFAULT 0,
  PRIMARY KEY (code)
)
";

$_SQL[] = "
CREATE OR REPLACE FUNCTION UNIX_TIMESTAMP(timestamp with time zone) RETURNS integer AS '
SELECT ROUND(EXTRACT(EPOCH FROM ABSTIME($1)))::int4 AS result;
' LANGUAGE SQL;
";

$_SQL[] = "
CREATE OR REPLACE FUNCTION UNIX_TIMESTAMP() RETURNS integer AS '
SELECT ROUND(EXTRACT(EPOCH FROM ABSTIME(NOW())))::int4 AS result;
' LANGUAGE SQL;
";

$_SQL[] = "CREATE OR REPLACE FUNCTION FROM_UNIXTIME(integer) RETURNS timestamp AS '
SELECT $1::ABSTIME::TIMESTAMP AS result;
' LANGUAGE SQL;
";

$_SQL[] = "CREATE OR REPLACE FUNCTION CURDATE() RETURNS date AS 'SELECT current_date AS result' LANGUAGE SQL;";

// Data
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (1,3) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (2,3) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (4,3) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (70,3) ";
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
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (23,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (24,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (25,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (26,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (27,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (28,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (29,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (30,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (31,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (32,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (33,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (34,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (35,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (36,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (37,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (38,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (39,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (40,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (41,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (42,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (43,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (44,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (45,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (46,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (47,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (48,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (49,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (50,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (51,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (52,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (53,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (54,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (55,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (56,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (57,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (58,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (59,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (60,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (61,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (62,3) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (62,17) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (63,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (64,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (65,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (66,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (67,16) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (68,18) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (69,19) ";

$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ((SELECT NEXTVAL('{$_TABLES['blocks']}_bid_seq')),1,'user_block','gldefault','User Functions',20,'','','epoch',1,'',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ((SELECT NEXTVAL('{$_TABLES['blocks']}_bid_seq')),1,'admin_block','gldefault','Admins Only',20,'','','epoch',1,'',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ((SELECT NEXTVAL('{$_TABLES['blocks']}_bid_seq')),1,'section_block','gldefault','Topics',10,'','','epoch',1,'',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ((SELECT NEXTVAL('{$_TABLES['blocks']}_bid_seq')),1,'whats_new_block','gldefault','What''s New',30,'','','epoch',0,'',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ((SELECT NEXTVAL('{$_TABLES['blocks']}_bid_seq')),1,'first_block','normal','About Geeklog',20,'<p><b>Welcome to Geeklog!</b></p><p>If you''re already familiar with Geeklog - and especially if you''re not: There have been many improvements to Geeklog since earlier versions that you might want to read up on. Please read the <a href=\"docs/english/changes.html\">release notes</a>. If you need help, please see the <a href=\"docs/english/support.html\">support options</a>.</p>','','epoch',0,'',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ((SELECT NEXTVAL('{$_TABLES['blocks']}_bid_seq')),1,'whosonline_block','phpblock','Who''s Online',10,'','','epoch',0,'phpblock_whosonline',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ((SELECT NEXTVAL('{$_TABLES['blocks']}_bid_seq')),1,'older_stories','gldefault','Older Stories',40,'','','epoch',1,'',4,2,3,3,2,2) ";

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
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_site', 'Access to configure site', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_mail', 'Access to configure mail', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_syndication', 'Access to configure syndication', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_paths', 'Access to configure paths', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_pear', 'Access to configure PEAR', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_mysql', 'Access to configure MySQL', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_search', 'Access to configure search', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_story', 'Access to configure story', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_trackback', 'Access to configure trackback', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_pingback', 'Access to configure pingback', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_theme', 'Access to configure theme', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_theme_advanced', 'Access to configure theme advanced settings', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_admin_block', 'Access to configure admin block', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_topics_block', 'Access to configure topics block', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_whosonline_block', 'Access to configure who''s online block', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_whatsnew_block', 'Access to configure what''s new block', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_users', 'Access to configure users', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_spamx', 'Access to configure Spam-x', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_login', 'Access to configure login settings', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_user_submission', 'Access to configure user submission', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_submission', 'Access to configure submission settings', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_comments', 'Access to configure comments', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_imagelib', 'Access to configure image library', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_upload', 'Access to configure upload', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_articleimg', 'Access to configure images in article', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_topicicon', 'Access to configure topic icons', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_userphoto', 'Access to configure photos', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_gravatar', 'Access to configure gravatar', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_language', 'Access to configure language', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_locale', 'Access to configure locale', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_cookies', 'Access to configure cookies', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_misc', 'Access to configure miscellaneous settings', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_debug', 'Access to configure debug', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_daily_digest', 'Access to configure daily digest', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_htmlfilter', 'Access to configure HTML filtering', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_censoring', 'Access to configure censoring', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_iplookup', 'Access to configure IP lookup', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_permissions', 'Access to configure default permissions for story, topic, block and autotags', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Core.tab_webservices', 'Access to configure webservices', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'filemanager.admin', 'Ability to use File Manager', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Filemanager.tab_general', 'Access to configure Filemanager General Settings', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Filemanager.tab_upload', 'Access to configure Filemanager Upload Settings', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Filemanager.tab_images', 'Access to configure Filemanager Images Settings', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Filemanager.tab_videos', 'Access to configure Filemanager Videos Settings', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'config.Filemanager.tab_audios', 'Access to configure Filemanager Audios Settings', 0)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'language.edit', 'Can manage Language Settings', 1)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'theme.edit', 'Can manage Theme Settings', 1)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'structureddata.autotag', 'Can use the Structured Data Autotag', 1)";

// Anonymous User (1) and Admin User (2) belongs to All Users (2)
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,1,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,2,NULL) ";
// Admin User (2) belongs to Logged-in Users (13)
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,2,NULL) ";
// Admin User (2) belongs to everything so assign to Root Group (1)
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (1,2,NULL) ";
// User Admin Group (9) belongs to Group Admin Group (11)
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,NULL,11) ";
// Root Group Assignments - Belongs to every group except itself (1), All Users (2), Remote Users (7)
// Remember any NEW GROUPS needs to be added to Root Group
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (3,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (4,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (5,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (6,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (8,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (10,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (11,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (12,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (14,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (15,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (16,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (17,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (18,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (19,NULL,1) ";

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
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ((SELECT nextval('{$_TABLES['groups']}_grp_id_seq')), 'Configuration Admin', 'Has full access to configuration', 1);";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ((SELECT nextval('{$_TABLES['groups']}_grp_id_seq')), 'Filemanager Admin', 'Has full access to File Manager', 1);";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ((SELECT nextval('{$_TABLES['groups']}_grp_id_seq')), 'Language Admin', 'Has full access to language', 1);";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ((SELECT nextval('{$_TABLES['groups']}_grp_id_seq')), 'Theme Admin', 'Has full access to themes', 1);";

$_DATA[] = "INSERT INTO {$_TABLES['pingservice']} (pid, name, site_url, ping_url, method, is_enabled) VALUES ((SELECT nextval('{$_TABLES['pingservice']}_pid_seq')), 'Ping-O-Matic', 'http://pingomatic.com/', 'http://rpc.pingomatic.com/', 'weblogUpdates.ping', 1)";

$_DATA[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/article/@sid', '/article.php?story=@sid', 100)";
$_DATA[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/article/@sid/print', '/article.php?story=@sid&mode=print', 110)";
$_DATA[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/article/@sid/@page', '/article.php?story=@sid&page=@page', 120)";
$_DATA[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/topic/@topic', '/index.php?topic=@topic', 130)";
$_DATA[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/topic/@topic/@page', '/index.php?topic=@topic&page=@page', 140)";
$_DATA[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/archives/@topic/@year/@month', '/directory.php?topic=@topic&year=@year&month=@month', 150)";
$_DATA[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/page/@page', '/staticpages/index.php?page=@page', 160)";
$_DATA[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/page/@page/print', '/staticpages/index.php?page=@page&disp_mode=print', 170)";
$_DATA[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/links/portal/@item', '/links/portal.php?what=link&item=@item', 180)";
$_DATA[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/links/category/@cat', '/links/index.php?category=@cat', 190)";

$_DATA[] = "INSERT INTO {$_TABLES['stories']} (sid, uid, draft_flag, date, title, introtext, bodytext, hits, numemails, comments, related, featured, commentcode, structured_data_type, statuscode, postmode, frontpage, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('welcome',2,0,NOW(),'Welcome to Geeklog!','<p>Welcome and let me be the first to congratulate you on installing Geeklog. Please take the time to read everything in the <a href=\"docs/english/index.html\">docs directory</a>. Geeklog now has enhanced, user-based security.  You should thoroughly understand how these work before you run a production Geeklog Site.</p>\r<p>To log into your new Geeklog site, please use this account:</p>\r<p>Username: <b>Admin</b><br />\rPassword: <b>password</b></p><p><b>And don''t forget to <a href=\"usersettings.php\">change your password</a> after logging in!</b></p>','',100,1,0,'',1,0,'core-article',0,'html',1,2,3,3,2,2,2) ";

$_DATA[] = "INSERT INTO {$_TABLES['storysubmission']} (sid, uid, title, introtext, date, postmode) VALUES ('security-reminder',2,'Are you secure?','<p>This is a reminder to secure your site once you have Geeklog up and running. What you should do:</p>\r\r<ol>\r<li>Change the default password for the Admin account.</li>\r<li>Remove the install directory (you won''t need it any more).</li>\r</ol>',NOW(),'html') ";

$_DATA[] = "INSERT INTO {$_TABLES['syndication']} (type, topic, header_tid, format, limits, content_length, title, description, filename, charset, language, is_enabled, updated, update_info) VALUES ('article', '::all', 'all', 'RSS-2.0', 10, 1, 'Geeklog Site', 'Another Nifty Geeklog Site', 'geeklog.rss', 'iso-8859-1', 'en-gb', 1, 'epoch', NULL)";

$_DATA[] = "INSERT INTO {$_TABLES['topic_assignments']} (tid, type, id, inherit, tdefault) VALUES ('all', 'block', '1', 1, 0)";
$_DATA[] = "INSERT INTO {$_TABLES['topic_assignments']} (tid, type, id, inherit, tdefault) VALUES ('all', 'block', '2', 1, 0)";
$_DATA[] = "INSERT INTO {$_TABLES['topic_assignments']} (tid, type, id, inherit, tdefault) VALUES ('all', 'block', '3', 1, 0)";
$_DATA[] = "INSERT INTO {$_TABLES['topic_assignments']} (tid, type, id, inherit, tdefault) VALUES ('all', 'block', '4', 1, 0)";
$_DATA[] = "INSERT INTO {$_TABLES['topic_assignments']} (tid, type, id, inherit, tdefault) VALUES ('homeonly', 'block', '5', 1, 0)";
$_DATA[] = "INSERT INTO {$_TABLES['topic_assignments']} (tid, type, id, inherit, tdefault) VALUES ('all', 'block', '6', 1, 0)";
$_DATA[] = "INSERT INTO {$_TABLES['topic_assignments']} (tid, type, id, inherit, tdefault) VALUES ('all', 'block', '7', 1, 0)";
$_DATA[] = "INSERT INTO {$_TABLES['topic_assignments']} (tid, type, id, inherit, tdefault) VALUES ('Geeklog', 'article', 'welcome', 1, 1)";
$_DATA[] = "INSERT INTO {$_TABLES['topic_assignments']} (tid, type, id, inherit, tdefault) VALUES ('Geeklog', 'article', 'security-reminder', 1, 1)";

$_DATA[] = "INSERT INTO {$_TABLES['topics']} (tid, topic, imageurl, meta_description, meta_keywords, sortnum, limitnews, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('General','General News','/images/topics/topic_news.png','A topic that contains general news related posts.','News, Post, Information',1,10,6,2,3,2,2,2)";
$_DATA[] = "INSERT INTO {$_TABLES['topics']} (tid, topic, imageurl, meta_description, meta_keywords, sortnum, limitnews, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('Geeklog','Geeklog','/images/topics/topic_gl.png','A topic that contains posts about Geeklog.','Geeklog, Posts, Information',2,10,6,2,3,2,2,2)";

// For guest user
$_DATA[] = "INSERT INTO {$_TABLES['user_attributes']} 
    (uid, etids, about, pgpkey, advanced_editor, emailfromadmin, emailfromuser) 
    VALUES (1, '', '', '', 0, 0, 0) 
";

// For Root user
$_DATA[] = "INSERT INTO {$_TABLES['user_attributes']} 
    (uid, etids, about, pgpkey, advanced_editor, emailfromadmin, emailfromuser) 
    VALUES (2, '', '', '', 1, 1, 1) 
";

#
# Dumping data for table 'users'
#

$_DATA[] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme, status) VALUES ((SELECT NEXTVAL('{$_TABLES['users']}_uid_seq')),'Anonymous','Anonymous','',NULL,NULL,'',NOW(),0,NULL,3) ";
$_DATA[] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme, status) VALUES ((SELECT NEXTVAL('{$_TABLES['users']}_uid_seq')),'Admin','Geeklog SuperUser','5f4dcc3b5aa765d61d8327deb882cf99','root@localhost','https://www.geeklog.net/','',NOW(),28800,NULL,3) ";

$_DATA[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('totalhits','0') ";
$_DATA[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('lastemailedstories','') ";
$_DATA[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('last_scheduled_run','') ";
$_DATA[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('last_article_publish','') ";
$_DATA[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('database_version','0.0.0') ";
