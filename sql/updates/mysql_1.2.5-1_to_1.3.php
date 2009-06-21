<?php

$_SQL[a] = "CREATE TABLE {$_TABLES['access']} (
  acc_ft_id mediumint(8) NOT NULL default '0',
  acc_grp_id mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (acc_ft_id,acc_grp_id)
) TYPE=MyISAM";

$_SQL[b] = "ALTER TABLE {$_TABLES['blocks']} ADD name varchar(48) NOT NULL default ''";
$_SQL[c] = "ALTER TABLE {$_TABLES['blocks']} DROP seclev";
$_SQL[d] = "ALTER TABLE {$_TABLES['blocks']} ADD onleft tinyint(3) unsigned NOT NULL default '1'";
$_SQL[e] = "ALTER TABLE {$_TABLES['blocks']} ADD phpblockfn varchar(64) default ''";
$_SQL[f] = "ALTER TABLE {$_TABLES['blocks']} ADD group_id mediumint(8) unsigned NOT NULL default '1'";
$_SQL[g] = "ALTER TABLE {$_TABLES['blocks']} ADD owner_id mediumint(8) unsigned NOT NULL default '0'";
$_SQL[h] = "ALTER TABLE {$_TABLES['blocks']} ADD perm_owner tinyint(1) unsigned NOT NULL default '3'";
$_SQL[i] = "ALTER TABLE {$_TABLES['blocks']} ADD perm_group tinyint(1) unsigned NOT NULL default '3'";
$_SQL[j] = "ALTER TABLE {$_TABLES['blocks']} ADD perm_members tinyint(1) unsigned NOT NULL default '2'";
$_SQL[k] = "ALTER TABLE {$_TABLES['blocks']} ADD perm_anon tinyint(1) unsigned NOT NULL default '2'";

$_SQL[l] = "CREATE TABLE {$_TABLES['cookiecodes']} (
  cc_value int(8) unsigned NOT NULL default '0',
  cc_descr varchar(20) NOT NULL default '',
  PRIMARY KEY  (cc_value)
) TYPE=MyISAM";

$_SQL[m] = "ALTER TABLE {$_TABLES['events']} MODIFY location varchar(128) default NULL";
$_SQL[n] = "ALTER TABLE {$_TABLES['events']} ADD event_type varchar(40) NOT NULL default ''";
$_SQL[o] = "ALTER TABLE {$_TABLES['events']} ADD timestart time default NULL";
$_SQL[p] = "ALTER TABLE {$_TABLES['events']} ADD timeend time default NULL";
$_SQL[q] = "ALTER TABLE {$_TABLES['events']} ADD allday tinyint(1) NOT NULL default '0'";
$_SQL[r] = "ALTER TABLE {$_TABLES['events']} ADD address1 varchar(40) default NULL";
$_SQL[s] = "ALTER TABLE {$_TABLES['events']} ADD address2 varchar(40) default NULL";
$_SQL[t] = "ALTER TABLE {$_TABLES['events']} ADD city varchar(60) default NULL";
$_SQL[u] = "ALTER TABLE {$_TABLES['events']} ADD state char(2) default NULL";
$_SQL[v] = "ALTER TABLE {$_TABLES['events']} ADD zipcode varchar(5) default NULL";
$_SQL[w] = "ALTER TABLE {$_TABLES['events']} ADD group_id mediumint(8) unsigned NOT NULL default '1'";
$_SQL[x] = "ALTER TABLE {$_TABLES['events']} ADD owner_id mediumint(8) unsigned NOT NULL default '0'";
$_SQL[y] = "ALTER TABLE {$_TABLES['events']} ADD perm_owner tinyint(1) unsigned NOT NULL default '3'";
$_SQL[z] = "ALTER TABLE {$_TABLES['events']} ADD perm_group tinyint(1) unsigned NOT NULL default '3'";
$_SQL[a1] = "ALTER TABLE {$_TABLES['events']} ADD perm_members tinyint(1) unsigned NOT NULL default '2'";
$_SQL[b1] = "ALTER TABLE {$_TABLES['events']} ADD perm_anon tinyint(1) unsigned NOT NULL default '2'";

$_SQL[c1] = "ALTER TABLE {$_TABLES['eventsubmission']} MODIFY location varchar(128) default NULL";
$_SQL[d1] = "ALTER TABLE {$_TABLES['eventsubmission']} ADD event_type varchar(40) NOT NULL default ''";
$_SQL[e1] = "ALTER TABLE {$_TABLES['eventsubmission']} ADD timestart time default NULL";
$_SQL[f1] = "ALTER TABLE {$_TABLES['eventsubmission']} ADD timeend time default NULL";
$_SQL[g1] = "ALTER TABLE {$_TABLES['eventsubmission']} ADD allday tinyint(1) NOT NULL default '0'";
$_SQL[h1] = "ALTER TABLE {$_TABLES['eventsubmission']} ADD address1 varchar(40) default NULL";
$_SQL[i1] = "ALTER TABLE {$_TABLES['eventsubmission']} ADD address2 varchar(40) default NULL";
$_SQL[j1] = "ALTER TABLE {$_TABLES['eventsubmission']} ADD city varchar(60) default NULL";
$_SQL[k1] = "ALTER TABLE {$_TABLES['eventsubmission']} ADD state char(2) default NULL";
$_SQL[l1] = "ALTER TABLE {$_TABLES['eventsubmission']} ADD zipcode varchar(5) default NULL";

$_SQL[m1] = "CREATE TABLE {$_TABLES['features']} (
  ft_id mediumint(8) NOT NULL auto_increment,
  ft_name varchar(20) NOT NULL default '',
  ft_descr varchar(255) NOT NULL default '',
  ft_gl_core tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (ft_id),
  KEY ft_name (ft_name)
) TYPE=MyISAM";

$_SQL[n1] = "CREATE TABLE {$_TABLES['group_assignments']} (
  ug_main_grp_id mediumint(8) NOT NULL default '0',
  ug_uid mediumint(8) unsigned default NULL,
  ug_grp_id mediumint(8) unsigned default NULL,
  KEY ug_main_grp_id (ug_main_grp_id)
) TYPE=MyISAM";

$_SQL[o1] = "CREATE TABLE {$_TABLES['groups']} (
  grp_id mediumint(8) NOT NULL auto_increment,
  grp_name varchar(50) NOT NULL default '',
  grp_descr varchar(255) NOT NULL default '',
  grp_gl_core tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (grp_id),
  KEY grp_name (grp_name)
) TYPE=MyISAM";

$_SQL[p1] = "ALTER TABLE {$_TABLES['links']} ADD group_id mediumint(8) unsigned NOT NULL default '1'";
$_SQL[q1] = "ALTER TABLE {$_TABLES['links']} ADD owner_id mediumint(8) unsigned NOT NULL default '0'";
$_SQL[r1] = "ALTER TABLE {$_TABLES['links']} ADD perm_owner tinyint(1) unsigned NOT NULL default '3'";
$_SQL[s1] = "ALTER TABLE {$_TABLES['links']} ADD perm_group tinyint(1) unsigned NOT NULL default '3'";
$_SQL[t1] = "ALTER TABLE {$_TABLES['links']} ADD perm_members tinyint(1) unsigned NOT NULL default '2'";
$_SQL[u1] = "ALTER TABLE {$_TABLES['links']} ADD perm_anon tinyint(1) unsigned NOT NULL default '2'";

$_SQL[v1] = "CREATE TABLE {$_TABLES['personal_events']} (
  eid varchar(20) NOT NULL default '',
  uid mediumint(8) NOT NULL default '0',
  title varchar(128) default NULL,
  event_type varchar(40) NOT NULL default '',
  datestart date default NULL,
  timestart time default NULL,
  dateend date default NULL,
  timeend time default NULL,
  location varchar(128) default NULL,
  address1 varchar(40) default NULL,
  address2 varchar(40) default NULL,
  city varchar(60) default NULL,
  state char(2) default NULL,
  zipcode varchar(5) default NULL,
  allday tinyint(1) NOT NULL default '0',
  url varchar(128) default NULL,
  description text,
  group_id mediumint(8) unsigned NOT NULL default '1',
  owner_id mediumint(8) unsigned NOT NULL default '0',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '3',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  PRIMARY KEY  (eid)
) TYPE=MyISAM";

$_SQL[w1] = "CREATE TABLE {$_TABLES['plugins']} (
  pi_name varchar(30) NOT NULL default '',
  pi_version varchar(20) NOT NULL default '',
  pi_gl_version varchar(20) NOT NULL default '',
  pi_enabled tinyint(3) unsigned NOT NULL default '1',
  pi_homepage varchar(128) NOT NULL default '',
  PRIMARY KEY  (pi_name)
) TYPE=MyISAM";

$_SQL[x1] = "ALTER TABLE {$_TABLES['stories']} ADD numemails mediumint(8) unsigned NOT NULL default '0'";
$_SQL[y1] = "ALTER TABLE {$_TABLES['stories']} ADD owner_id mediumint(8) NOT NULL default '0'";
$_SQL[z1] = "ALTER TABLE {$_TABLES['stories']} ADD group_id mediumint(8) NOT NULL default '2'";
$_SQL[a2] = "ALTER TABLE {$_TABLES['stories']} ADD perm_owner tinyint(1) unsigned NOT NULL default '3'";
$_SQL[b2] = "ALTER TABLE {$_TABLES['stories']} ADD perm_group tinyint(1) unsigned NOT NULL default '3'";
$_SQL[c2] = "ALTER TABLE {$_TABLES['stories']} ADD perm_members tinyint(1) unsigned NOT NULL default '2'";
$_SQL[d2] = "ALTER TABLE {$_TABLES['stories']} ADD perm_anon tinyint(1) unsigned NOT NULL default '2'";

$_SQL[e2] = "ALTER TABLE {$_TABLES['topics']} ADD group_id mediumint(8) unsigned NOT NULL default '1'";
$_SQL[f2] = "ALTER TABLE {$_TABLES['topics']} ADD owner_id mediumint(8) unsigned NOT NULL default '0'";
$_SQL[g2] = "ALTER TABLE {$_TABLES['topics']} ADD perm_owner tinyint(1) unsigned NOT NULL default '3'";
$_SQL[h2] = "ALTER TABLE {$_TABLES['topics']} ADD perm_group tinyint(1) unsigned NOT NULL default '3'";
$_SQL[i2] = "ALTER TABLE {$_TABLES['topics']} ADD perm_members tinyint(1) unsigned NOT NULL default '2'";
$_SQL[j2] = "ALTER TABLE {$_TABLES['topics']} ADD perm_anon tinyint(1) unsigned NOT NULL default '2'";

$_SQL[k2] = "DROP TABLE {$_TABLES['userevent']}";

$_SQL[l2] = "ALTER TABLE {$_TABLES['users']} ADD regdate datetime NOT NULL default '0000-00-00 00:00:00'";
$_SQL[m2] = "ALTER TABLE {$_TABLES['users']} ADD cookietimeout int(8) unsigned default '0'";
$_SQL[n2] = "ALTER TABLE {$_TABLES['users']} ADD theme varchar(64) default NULL";
$_SQL[o2] = "ALTER TABLE {$_TABLES['users']} DROP seclev";
$_SQL[p2] = "ALTER TABLE {$_TABLES['users']} ADD language varchar(64) default NULL";

// Now include needed data
$_SQL[1] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (1,3) ";
$_SQL[2] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (2,3) ";
$_SQL[3] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (3,5) ";
$_SQL[4] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (4,5) ";
$_SQL[5] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (5,9) ";
$_SQL[6] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (5,11) ";
$_SQL[7] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (6,9) ";
$_SQL[8] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (6,11) ";
$_SQL[9] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (8,7) ";
$_SQL[10] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (9,7) ";
$_SQL[11] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (10,4) ";
$_SQL[12] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (11,6) ";
$_SQL[13] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (12,8) ";
$_SQL[14] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (13,10) ";
$_SQL[15] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (14,11) ";
$_SQL[16] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (15,11) ";
$_SQL[17] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (16,4) ";

$_SQL[18] = "INSERT INTO {$_TABLES['blocks']} (name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('user_block','gldefault','User Block','all',2,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ";
$_SQL[19] = "INSERT INTO {$_TABLES['blocks']} (name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('admin_block','gldefault','Admin Block','all',1,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ";
$_SQL[20] = "INSERT INTO {$_TABLES['blocks']} (name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('section_block','gldefault','Section Block','all',0,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ";
$_SQL[21] = "INSERT INTO {$_TABLES['blocks']} (name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('poll_block','gldefault','Poll Block','all',2,'','','0000-00-00 00:00:00',0,'0',1,2,3,3,2,2) ";
$_SQL[22] = "INSERT INTO {$_TABLES['blocks']} (name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('events_block','gldefault','Events Block','all',3,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ";
$_SQL[23] = "INSERT INTO {$_TABLES['blocks']} (name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('whats_new_block','gldefault','Whats New Block','all',3,'','','0000-00-00 00:00:00',0,'1',1,2,3,3,2,2) ";

$_SQL[40] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (3600,'1 Hour') ";
$_SQL[41] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (7200,'2 Hours') ";
$_SQL[42] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (10800,'3 Hours') ";
$_SQL[43] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (28800,'8 Hours') ";
$_SQL[44] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (86400,'1 Day') ";
$_SQL[45] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (604800,'1 Week') ";
$_SQL[46] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (2678400,'1 Month') ";
$_SQL[47] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (31536000,'1 Year') ";

$_SQL[69] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (1,'story.edit','Access to story editor',1) ";
$_SQL[70] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (2,'story.moderate','Ablility to moderate pending stories',1) ";
$_SQL[71] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (3,'link.moderate','Ablility to moderate pending links',1) ";
$_SQL[72] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (4,'link.edit','Access to link editor',1) ";
$_SQL[73] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (5,'user.edit','Access to user editor',1) ";
$_SQL[74] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (6,'user.delete','Ablility to delete a user',1) ";
$_SQL[75] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (7,'user.mail','Ablility to send email to members',1) ";
$_SQL[76] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (8,'event.moderate','Ablility to moderate pending events',1) ";
$_SQL[77] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (9,'event.edit','Access to event editor',1) ";
$_SQL[78] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (10,'block.edit','Access to block editor',1) ";$_SQL[79] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (11,'topic.edit','Access to topic editor',1) ";$_SQL[80] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (12,'poll.edit','Access to poll editor',1) ";
$_SQL[81] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (13,'plugin.edit','Access to plugin editor',1)
";
$_SQL[82] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (14,'group.edit','Ability to edit groups',1) ";$_SQL[83] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (15,'group.delete','Ability to delete groups',1) ";
$_SQL[84] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (16,'block.delete','Ability to delete a block',1) ";

$_SQL[320] = "INSERT INTO {$_TABLES['users']} (username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES ('NewAdmin','Geeklog SuperUser','5f4dcc3b5aa765d61d8327deb882cf99','root@localhost','http://geekog.sourceforge.net','','0000-00-00 00:00:00',0,NULL) ";
$_SQL[87] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,1,NULL) ";
$_SQL[88] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,1) ";
$_SQL[89] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (3,NULL,1) ";
$_SQL[90] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (4,NULL,1) ";
$_SQL[91] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (5,NULL,1) ";
$_SQL[92] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (6,NULL,1) ";
$_SQL[93] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (7,NULL,1) ";
$_SQL[94] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (8,NULL,1) ";
$_SQL[95] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,NULL,1) ";
$_SQL[96] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (10,NULL,1) ";
$_SQL[97] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (11,NULL,1) ";
$_SQL[98] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,LAST_INSERT_ID(),NULL) ";
$_SQL[99] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (12,LAST_INSERT_ID(),NULL) ";
$_SQL[100] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (11,LAST_INSERT_ID(),NULL) ";
$_SQL[101] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,12) ";
$_SQL[102] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,10) ";
$_SQL[103] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,9) ";
$_SQL[104] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,8) ";
$_SQL[105] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,7) ";
$_SQL[106] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,6) ";
$_SQL[107] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,5) ";
$_SQL[108] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,4) ";
$_SQL[109] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,3) ";
$_SQL[110] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (12,NULL,1) ";
$_SQL[111] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,NULL,11) ";
$_SQL[112] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,11) ";
$_SQL[138] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (10,LAST_INSERT_ID(),NULL) ";
$_SQL[139] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,LAST_INSERT_ID(),NULL) ";
$_SQL[140] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (8,LAST_INSERT_ID(),NULL) ";
$_SQL[141] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (7,LAST_INSERT_ID(),NULL) ";
$_SQL[142] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (6,LAST_INSERT_ID(),NULL) ";
$_SQL[143] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (5,LAST_INSERT_ID(),NULL) ";
$_SQL[144] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (4,LAST_INSERT_ID(),NULL) ";
$_SQL[145] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (3,LAST_INSERT_ID(),NULL) ";
$_SQL[146] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,LAST_INSERT_ID(),NULL) ";
$_SQL[147] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (1,LAST_INSERT_ID(),NULL) ";

$_SQL[151] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (1,'Root','Has full access to the site',1) ";
$_SQL[152] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (2,'All Users','Group that a typical user is added to',1) ";
$_SQL[153] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (3,'Story Admin','Has full access to story features',1) ";
$_SQL[154] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (4,'Block Admin','Has full access to block features',1) ";
$_SQL[155] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (5,'Link Admin','Has full access to link features',1) ";
$_SQL[156] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (6,'Topic Admin','Has full access to topic features',1) ";
$_SQL[157] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (7,'Event Admin','Has full access to event features',1) ";
$_SQL[158] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (8,'Poll Admin','Has full access to poll features',1) ";
$_SQL[159] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (9,'User Admin','Has full access to user features',1) ";
$_SQL[160] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (10,'Plugin Admin','Has full access to plugin features',1) ";
$_SQL[161] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (11,'Group Admin','Is a User Admin with Acces to Groups too',1) ";
$_SQL[162] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (12,'Mail Admin','Can Use Mail Utility',1) ";
$_SQL[163] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (13,'Logged-in Users','All users except anonymous should belong to this group',1) ";

$_SQL[164] = "ALTER TABLE {$_TABLES['pollquestions']} ADD group_id mediumint(8) unsigned NOT NULL default '1'";
$_SQL[165] = "ALTER TABLE {$_TABLES['pollquestions']} ADD owner_id mediumint(8) unsigned NOT NULL default '1'";
$_SQL[166] = "ALTER TABLE {$_TABLES['pollquestions']} ADD perm_owner tinyint(1) unsigned NOT NULL default '3'";
$_SQL[167] = "ALTER TABLE {$_TABLES['pollquestions']} ADD perm_group tinyint(1) unsigned NOT NULL default '3'";
$_SQL[168] = "ALTER TABLE {$_TABLES['pollquestions']} ADD perm_members tinyint(1) unsigned NOT NULL default '2'";
$_SQL[169] = "ALTER TABLE {$_TABLES['pollquestions']} ADD perm_anon tinyint(1) unsigned NOT NULL default '2'";
?>
