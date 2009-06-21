CREATE TABLE access (
  acc_ft_id mediumint(8) NOT NULL default '0',
  acc_grp_id mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (acc_ft_id,acc_grp_id)
) TYPE=MyISAM;

ALTER TABLE blocks ADD name varchar(48) NOT NULL default '';
ALTER TABLE blocks DROP seclev;
ALTER TABLE blocks ADD onleft tinyint(3) unsigned NOT NULL default '1';
ALTER TABLE blocks ADD phpblockfn varchar(64) default '';
ALTER TABLE blocks ADD group_id mediumint(8) unsigned NOT NULL default '1';
ALTER TABLE blocks ADD owner_id mediumint(8) unsigned NOT NULL default '0';
ALTER TABLE blocks ADD perm_owner tinyint(1) unsigned NOT NULL default '3';
ALTER TABLE blocks ADD perm_group tinyint(1) unsigned NOT NULL default '3';
ALTER TABLE blocks ADD perm_members tinyint(1) unsigned NOT NULL default '2';
ALTER TABLE blocks ADD perm_anon tinyint(1) unsigned NOT NULL default '2';

CREATE TABLE cookiecodes (
  cc_value int(8) unsigned NOT NULL default '0',
  cc_descr varchar(20) NOT NULL default '',
  PRIMARY KEY  (cc_value)
) TYPE=MyISAM;

ALTER TABLE events MODIFY location varchar(128) default NULL;
ALTER TABLE events ADD event_type varchar(40) NOT NULL default '';
ALTER TABLE events ADD timestart time default NULL;
ALTER TABLE events ADD timeend time default NULL;
ALTER TABLE events ADD allday tinyint(1) NOT NULL default '0';
ALTER TABLE events ADD address1 varchar(40) default NULL;
ALTER TABLE events ADD address2 varchar(40) default NULL;
ALTER TABLE events ADD city varchar(60) default NULL;
ALTER TABLE events ADD state char(2) default NULL;
ALTER TABLE events ADD zipcode varchar(5) default NULL;
ALTER TABLE events ADD group_id mediumint(8) unsigned NOT NULL default '1';
ALTER TABLE events ADD owner_id mediumint(8) unsigned NOT NULL default '0';
ALTER TABLE events ADD perm_owner tinyint(1) unsigned NOT NULL default '3';
ALTER TABLE events ADD perm_group tinyint(1) unsigned NOT NULL default '3';
ALTER TABLE events ADD perm_members tinyint(1) unsigned NOT NULL default '2';
ALTER TABLE events ADD perm_anon tinyint(1) unsigned NOT NULL default '2';
ALTER TABLE eventsubmission MODIFY location varchar(128) default NULL;
ALTER TABLE eventsubmission ADD event_type varchar(40) NOT NULL default '';
ALTER TABLE eventsubmission ADD timestart time default NULL;
ALTER TABLE eventsubmission ADD timeend time default NULL;
ALTER TABLE eventsubmission ADD allday tinyint(1) NOT NULL default '0';
ALTER TABLE eventsubmission ADD address1 varchar(40) default NULL;
ALTER TABLE eventsubmission ADD address2 varchar(40) default NULL;
ALTER TABLE eventsubmission ADD city varchar(60) default NULL;
ALTER TABLE eventsubmission ADD state char(2) default NULL;
ALTER TABLE eventsubmission ADD zipcode varchar(5) default NULL;

CREATE TABLE features (
  ft_id mediumint(8) NOT NULL auto_increment,
  ft_name varchar(20) NOT NULL default '',
  ft_descr varchar(255) NOT NULL default '',
  ft_gl_core tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (ft_id),
  KEY ft_name (ft_name)
) TYPE=MyISAM;
                        
CREATE TABLE group_assignments (
  ug_main_grp_id mediumint(8) NOT NULL default '0',
  ug_uid mediumint(8) unsigned default NULL,
  ug_grp_id mediumint(8) unsigned default NULL,
  KEY ug_main_grp_id (ug_main_grp_id)
) TYPE=MyISAM;

CREATE TABLE groups (
  grp_id mediumint(8) NOT NULL auto_increment,
  grp_name varchar(50) NOT NULL default '',
  grp_descr varchar(255) NOT NULL default '',
  grp_gl_core tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (grp_id),
  KEY grp_name (grp_name)
) TYPE=MyISAM;

ALTER TABLE links ADD group_id mediumint(8) unsigned NOT NULL default '1';
ALTER TABLE links ADD owner_id mediumint(8) unsigned NOT NULL default '0';
ALTER TABLE links ADD perm_owner tinyint(1) unsigned NOT NULL default '3';
ALTER TABLE links ADD perm_group tinyint(1) unsigned NOT NULL default '3';
ALTER TABLE links ADD perm_members tinyint(1) unsigned NOT NULL default '2';
ALTER TABLE links ADD perm_anon tinyint(1) unsigned NOT NULL default '2';

CREATE TABLE personal_events (
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
) TYPE=MyISAM;

CREATE TABLE plugins (
  pi_name varchar(30) NOT NULL default '',
  pi_version varchar(20) NOT NULL default '',
  pi_gl_version varchar(20) NOT NULL default '',
  pi_enabled tinyint(3) unsigned NOT NULL default '1',
  pi_homepage varchar(128) NOT NULL default '',
  PRIMARY KEY  (pi_name)
) TYPE=MyISAM;
                                                                                                        
ALTER TABLE stories ADD numemails mediumint(8) unsigned NOT NULL default '0';
ALTER TABLE stories ADD owner_id mediumint(8) NOT NULL default '0';
ALTER TABLE stories ADD group_id mediumint(8) NOT NULL default '2';
ALTER TABLE stories ADD perm_owner tinyint(1) unsigned NOT NULL default '3';
ALTER TABLE stories ADD perm_group tinyint(1) unsigned NOT NULL default '3';
ALTER TABLE stories ADD perm_members tinyint(1) unsigned NOT NULL default '2';
ALTER TABLE stories ADD perm_anon tinyint(1) unsigned NOT NULL default '2';
ALTER TABLE topics ADD group_id mediumint(8) unsigned NOT NULL default '1';
ALTER TABLE topics ADD owner_id mediumint(8) unsigned NOT NULL default '0';
ALTER TABLE topics ADD perm_owner tinyint(1) unsigned NOT NULL default '3';
ALTER TABLE topics ADD perm_group tinyint(1) unsigned NOT NULL default '3';
ALTER TABLE topics ADD perm_members tinyint(1) unsigned NOT NULL default '2';
ALTER TABLE topics ADD perm_anon tinyint(1) unsigned NOT NULL default '2';
DROP TABLE userevent;
ALTER TABLE users ADD regdate datetime NOT NULL default '0000-00-00 00:00:00';
ALTER TABLE users ADD cookietimeout int(8) unsigned default '0';
ALTER TABLE users ADD theme varchar(64) default NULL;
ALTER TABLE users ADD language varchar(64) default NULL;
ALTER TABLE users DROP seclev;
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (1,3) ;
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (2,3) ;
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (3,5) ;
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (4,5) ;
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (5,9) ;
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (5,11) ;
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (6,9) ;
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (6,11) ;
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (8,7) ;
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (9,7) ;
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (10,4) ;
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (11,6) ;
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (12,8) ;
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (13,10) ;
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (14,11) ;
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (15,11) ;
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (16,4) ;
INSERT INTO blocks (name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('user_block','gldefault','User Block','all',2,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ;
INSERT INTO blocks (name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('admin_block','gldefault','Admin Block','all',1,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ;
INSERT INTO blocks (name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('section_block','gldefault','Section Block','all',0,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ;
INSERT INTO blocks (name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('poll_block','gldefault','Poll Block','all',2,'','','0000-00-00 00:00:00',0,'0',1,2,3,3,2,2) ;
INSERT INTO blocks (name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('events_block','gldefault','Events Block','all',3,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ;
INSERT INTO blocks (name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('whats_new_block','gldefault','Whats New Block','all',3,'','','0000-00-00 00:00:00',0,'1',1,2,3,3,2,2) ;
INSERT INTO cookiecodes (cc_value, cc_descr) VALUES (3600,'1 Hour') ;
INSERT INTO cookiecodes (cc_value, cc_descr) VALUES (7200,'2 Hours') ;
INSERT INTO cookiecodes (cc_value, cc_descr) VALUES (10800,'3 Hours') ;
INSERT INTO cookiecodes (cc_value, cc_descr) VALUES (28800,'8 Hours') ;
INSERT INTO cookiecodes (cc_value, cc_descr) VALUES (86400,'1 Day') ;
INSERT INTO cookiecodes (cc_value, cc_descr) VALUES (604800,'1 Week') ;
INSERT INTO cookiecodes (cc_value, cc_descr) VALUES (2678400,'1 Month') ;
INSERT INTO cookiecodes (cc_value, cc_descr) VALUES (31536000,'1 Year') ;
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (1,'story.edit','Access to story editor',1) ;
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (2,'story.moderate','Ablility to moderate pending stories',1) ;
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (3,'link.moderate','Ablility to moderate pending links',1) ;
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (4,'link.edit','Access to link editor',1) ;
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (5,'user.edit','Access to user editor',1) ;
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (6,'user.delete','Ablility to delete a user',1) ;
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (7,'user.mail','Ablility to send email to members',1) ;
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (8,'event.moderate','Ablility to moderate pending events',1) ;
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (9,'event.edit','Access to event editor',1) ;
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (10,'block.edit','Access to block editor',1) ;
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (11,'topic.edit','Access to topic editor',1) ;
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (12,'poll.edit','Access to poll editor',1) ;
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (13,'plugin.edit','Access to plugin editor',1);
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (14,'group.edit','Ability to edit groups',1) ;
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (15,'group.delete','Ability to delete groups',1) ;
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (16,'block.delete','Ability to delete a block',1) ;
INSERT INTO users (username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES ('NewAdmin','Geeklog SuperUser','5f4dcc3b5aa765d61d8327deb882cf99','root@localhost','http://geekog.sourceforge.net','','0000-00-00 00:00:00',0,NULL) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,1,NULL) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,1) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (3,NULL,1) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (4,NULL,1) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (5,NULL,1) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (6,NULL,1) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (7,NULL,1) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (8,NULL,1) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,NULL,1) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (10,NULL,1) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (11,NULL,1) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,LAST_INSERT_ID(),NULL) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (12,LAST_INSERT_ID(),NULL) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (11,LAST_INSERT_ID(),NULL) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,12) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,10) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,9) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,8) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,7) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,6) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,5) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,4) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,3) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (12,NULL,1) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,NULL,11) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,11) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (10,LAST_INSERT_ID(),NULL) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,LAST_INSERT_ID(),NULL) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (8,LAST_INSERT_ID(),NULL) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (7,LAST_INSERT_ID(),NULL) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (6,LAST_INSERT_ID(),NULL) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (5,LAST_INSERT_ID(),NULL) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (4,LAST_INSERT_ID(),NULL) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (3,LAST_INSERT_ID(),NULL) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,LAST_INSERT_ID(),NULL) ;
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (1,LAST_INSERT_ID(),NULL) ;
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (1,'Root','Has full access to the site',1) ;
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (2,'All Users','Group that a typical user is added to',1) ;
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (3,'Story Admin','Has full access to story features',1) ;
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (4,'Block Admin','Has full access to block features',1) ;
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (5,'Link Admin','Has full access to link features',1) ;
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (6,'Topic Admin','Has full access to topic features',1) ;
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (7,'Event Admin','Has full access to event features',1) ;
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (8,'Poll Admin','Has full access to poll features',1) ;
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (9,'User Admin','Has full access to user features',1) ;
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (10,'Plugin Admin','Has full access to plugin features',1) ;
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (11,'Group Admin','Is a User Admin with Acces to Groups too',1) ;
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (12,'Mail Admin','Can Use Mail Utility',1) ;
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (13,'Logged-in Users','All users except anonymous should belong to this group',1) ;
ALTER TABLE pollquestions ADD group_id mediumint(8) unsigned NOT NULL default '1';
ALTER TABLE pollquestions ADD owner_id mediumint(8) unsigned NOT NULL default '1';
ALTER TABLE pollquestions ADD perm_owner tinyint(1) unsigned NOT NULL default '3';
ALTER TABLE pollquestions ADD perm_group tinyint(1) unsigned NOT NULL default '3';
ALTER TABLE pollquestions ADD perm_members tinyint(1) unsigned NOT NULL default '2';
ALTER TABLE pollquestions ADD perm_anon tinyint(1) unsigned NOT NULL default '2';
