# 
# Table structure for table 'access'
#

CREATE TABLE access (
  acc_ft_id mediumint(8) NOT NULL default '0',
  acc_grp_id mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (acc_ft_id,acc_grp_id)
) TYPE=MyISAM;

# 
# Dumping data for table 'access'
# 
  
INSERT INTO access VALUES (1,3); 
INSERT INTO access VALUES (2,3); 
INSERT INTO access VALUES (3,5); 
INSERT INTO access VALUES (4,5); 
INSERT INTO access VALUES (5,9);
INSERT INTO access VALUES (5,11);
INSERT INTO access VALUES (6,9);
INSERT INTO access VALUES (6,11);
INSERT INTO access VALUES (8,7);
INSERT INTO access VALUES (9,7);
INSERT INTO access VALUES (10,4);
INSERT INTO access VALUES (11,6);
INSERT INTO access VALUES (12,8);
INSERT INTO access VALUES (13,10);
INSERT INTO access VALUES (14,11);
INSERT INTO access VALUES (15,11);

#
# Table structure for table 'cookiecodes'
#

CREATE TABLE cookiecodes (
  cc_value int(8) unsigned DEFAULT '0' NOT NULL,
  cc_descr varchar(20) DEFAULT '' NOT NULL,
  PRIMARY KEY (cc_value)
) TYPE=MyISAM;

#
# Dumping data for table 'cookiecodes'
#

INSERT INTO cookiecodes VALUES (3600,'1 Hour');
INSERT INTO cookiecodes VALUES (7200,'2 Hours');
INSERT INTO cookiecodes VALUES (10800,'3 Hours');
INSERT INTO cookiecodes VALUES (28800,'8 Hours');
INSERT INTO cookiecodes VALUES (86400,'1 Day');
INSERT INTO cookiecodes VALUES (604800,'1 Week');
INSERT INTO cookiecodes VALUES (2678400,'1 Month');
INSERT INTO cookiecodes VALUES (31536000,'1 Year');

#
# Table structure for table 'plugins'
#

CREATE TABLE plugins(
	pi_name varchar(30) DEFAULT '' NOT NULL,
	pi_version varchar(20) DEFAULT '' NOT NULL,
	pi_gl_version varchar(20) DEFAULT '' NOT NULL,
	pi_enabled tinyint(3) unsigned DEFAULT '1' NOT NULL,
	pi_homepage varchar(128) DEFAULT '' NOT NULL,
	PRIMARY KEY(pi_name)
);

#
# Table modifications for table 'blocks'
#

ALTER TABLE blocks add phpblockfn varchar(64) DEFAULT '';
ALTER TABLE blocks add onleft tinyint(3) unsigned DEFAULT '0' NOT NULL;
ALTER TABLE blocks add owner_id mediumint(8) unsigned DEFAULT '0' NOT NULL;
ALTER TABLE blocks add group_id mediumint(8) unsigned DEFAULT '1' NOT NULL;
ALTER TABLE blocks add perm_owner tinyint(1) unsigned DEFAULT '3' NOT NULL;
ALTER TABLE blocks add perm_group tinyint(1) unsigned DEFAULT '3' NOT NULL;
ALTER TABLE blocks add perm_members tinyint(1) unsigned DEFAULT '2' NOT NULL;
ALTER TABLE blocks add perm_anon tinyint(1) unsigned DEFAULT '2' NOT NULL;

#
# Dumping data for table 'blocks'
#

INSERT INTO blocks VALUES (1,'blockheader','all',0,'layout','','0000-00-00 00:00:00','<table border=0 cellpadding=1 cellspacing=0 width=\"100%\"><tr bgcolor=666666><td>\r\n<table width=\"100%\" border=0 cellspacing=0 cellpadding=2>\r\n<tr bgcolor=666666><td class=blocktitle>%title</td><td align=right>%help</td></tr>\r\n<tr><td bgcolor=FFFFFF colspan=2>',0,'1',1,2,3,3,2,2);
INSERT INTO blocks VALUES (2,'blockfooter','all',0,'layout','','0000-00-00 00:00:00','</td></tr></table>\r\n</td></tr></table><br>',0,'1',1,2,3,3,2,2);
INSERT INTO blocks VALUES (3,'User Block','all',2,'gldefault','','0000-00-00 00:00:00','',1,'',1,2,3,3,2,2);
INSERT INTO blocks VALUES (4,'Admin Block','all',1,'gldefault','','0000-00-00 00:00:00','',1,'',1,2,3,3,2,2);
INSERT INTO blocks VALUES (5,'Section Block','all',0,'gldefault','','0000-00-00 00:00:00','',1,'',1,2,3,3,2,2);
INSERT INTO blocks VALUES (6,'Poll Block','all',2,'gldefault','','0000-00-00 00:00:00','',0,'0',1,2,3,3,2,2);
INSERT INTO blocks VALUES (7,'Events Block','all',3,'gldefault','','0000-00-00 00:00:00','',1,'',1,2,3,3,2,2);
INSERT INTO blocks VALUES (8,'Whats New Block','all',3,'gldefault','','0000-00-00 00:00:00','',0,'1',1,2,3,3,2,2);

CREATE TABLE features (
  ft_id mediumint(8) NOT NULL auto_increment,
  ft_name varchar(20) NOT NULL default '',
  ft_descr varchar(255) NOT NULL default '',
  ft_gl_core tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (ft_id),
  KEY ft_name (ft_name)
) TYPE=MyISAM;

#
# Dumping data for table 'features'
#

INSERT INTO features VALUES (1,'story.edit','Access to story editor',1);
INSERT INTO features VALUES (2,'story.moderate','Ablility to moderate pending stories',1);
INSERT INTO features VALUES (3,'link.moderate','Ablility to moderate pending links',1);
INSERT INTO features VALUES (4,'link.edit','Access to link editor',1);
INSERT INTO features VALUES (5,'user.edit','Access to user editor',1);
INSERT INTO features VALUES (6,'user.delete','Ablility to delete a user',1);
INSERT INTO features VALUES (7,'user.mail','Ablility to send email to members',1);
INSERT INTO features VALUES (8,'event.moderate','Ablility to moderate pending events',1);
INSERT INTO features VALUES (9,'event.edit','Access to event editor',1);
INSERT INTO features VALUES (10,'block.edit','Access to block editor',1);
INSERT INTO features VALUES (11,'topic.edit','Access to topic editor',1);
INSERT INTO features VALUES (12,'poll.edit','Access to poll editor',1);
INSERT INTO features VALUES (13,'plugin.edit','Access to plugin editor',1);
INSERT INTO features VALUES (14,'group.edit','Ability to edit groups',1);
INSERT INTO features VALUES (15,'group.delete','Ability to delete groups',1);

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
# Dumping data for table 'groups'
#

INSERT INTO groups VALUES (1,'Root','Has full access to the site',1);
INSERT INTO groups VALUES (2,'All Users','Group that a typical user is added to',1);
INSERT INTO groups VALUES (3,'Story Admin','Has full access to story features',1);
INSERT INTO groups VALUES (4,'Block Admin','Has full access to block features',1);
INSERT INTO groups VALUES (5,'Link Admin','Has full access to link features',1);
INSERT INTO groups VALUES (6,'Topic Admin','Has full access to topic features',1);
INSERT INTO groups VALUES (7,'Event Admin','Has full access to event features',1);
INSERT INTO groups VALUES (8,'Poll Admin','Has full access to poll features',1);
INSERT INTO groups VALUES (9,'User Admin','Has full access to user features',1);
INSERT INTO groups VALUES (10,'Plugin Admin','Has full access to plugin features',1);
INSERT INTO groups VALUES (11,'Group Admin','Is a User Admin with Acces to Groups too',1);
INSERT INTO groups VALUES (12,'Mail Admin','Can Mail Utility',1);
INSERT INTO groups VALUES (13,'Logged-in Users','All users except anonymous should belong to this group',1);

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
# Dumping data for table 'group_assignments'
#

INSERT INTO group_assignments VALUES (2,1,NULL);
INSERT INTO group_assignments VALUES (2,NULL,1);
INSERT INTO group_assignments VALUES (3,NULL,1);
INSERT INTO group_assignments VALUES (4,NULL,1);
INSERT INTO group_assignments VALUES (5,NULL,1);
INSERT INTO group_assignments VALUES (6,NULL,1);
INSERT INTO group_assignments VALUES (7,NULL,1);
INSERT INTO group_assignments VALUES (8,NULL,1);
INSERT INTO group_assignments VALUES (9,NULL,1);
INSERT INTO group_assignments VALUES (10,NULL,1);
INSERT INTO group_assignments VALUES (11,NULL,1);
INSERT INTO group_assignments VALUES (1,2,NULL);
INSERT INTO group_assignments VALUES (13,2,NULL);
INSERT INTO group_assignments VALUES (2,2,NULL);
INSERT INTO group_assignments VALUES (2,NULL,12);
INSERT INTO group_assignments VALUES (2,NULL,10);
INSERT INTO group_assignments VALUES (2,NULL,9);
INSERT INTO group_assignments VALUES (2,NULL,8);
INSERT INTO group_assignments VALUES (2,NULL,7);
INSERT INTO group_assignments VALUES (2,NULL,6);
INSERT INTO group_assignments VALUES (2,NULL,5);
INSERT INTO group_assignments VALUES (2,NULL,4);
INSERT INTO group_assignments VALUES (2,NULL,3);
INSERT INTO group_assignments VALUES (12,NULL,1);
INSERT INTO group_assignments VALUES (9,NULL,11);
INSERT INTO group_assignments VALUES (2,NULL,11);

#
# Table modifications for table 'topics'
#

ALTER TABLE topics add owner_id mediumint(8) unsigned DEFAULT '0' NOT NULL;
ALTER TABLE topics add group_id mediumint(8) unsigned DEFAULT '1' NOT NULL;
ALTER TABLE topics add perm_owner tinyint(1) unsigned DEFAULT '3' NOT NULL;
ALTER TABLE topics add perm_group tinyint(1) unsigned DEFAULT '3' NOT NULL;
ALTER TABLE topics add perm_members tinyint(1) unsigned DEFAULT '2' NOT NULL;
ALTER TABLE topics add perm_anon tinyint(1) unsigned DEFAULT '2' NOT NULL;

#
# Table modifications for table 'links'
#

ALTER TABLE links add owner_id mediumint(8) unsigned DEFAULT '0' NOT NULL;
ALTER TABLE links add group_id mediumint(8) unsigned DEFAULT '1' NOT NULL;
ALTER TABLE links add perm_owner tinyint(1) unsigned DEFAULT '3' NOT NULL;
ALTER TABLE links add perm_group tinyint(1) unsigned DEFAULT '3' NOT NULL;
ALTER TABLE links add perm_members tinyint(1) unsigned DEFAULT '2' NOT NULL;
ALTER TABLE links add perm_anon tinyint(1) unsigned DEFAULT '2' NOT NULL;

#
# Table modifications for table 'events'
#

ALTER TABLE events add owner_id mediumint(8) unsigned DEFAULT '0' NOT NULL;
ALTER TABLE events add group_id mediumint(8) unsigned DEFAULT '1' NOT NULL;
ALTER TABLE events add perm_owner tinyint(1) unsigned DEFAULT '3' NOT NULL;
ALTER TABLE events add perm_group tinyint(1) unsigned DEFAULT '3' NOT NULL;
ALTER TABLE events add perm_members tinyint(1) unsigned DEFAULT '2' NOT NULL;
ALTER TABLE events add perm_anon tinyint(1) unsigned DEFAULT '2' NOT NULL;

#
# Table modifications for table 'stories'
#

ALTER TABLE stories add numemails mediumint(8) unsigned DEFAULT '0' NOT NULL;
ALTER TABLE stories add owner_id mediumint(8) unsigned DEFAULT '0' NOT NULL;
ALTER TABLE stories add group_id mediumint(8) unsigned DEFAULT '1' NOT NULL;
ALTER TABLE stories add perm_owner tinyint(1) unsigned DEFAULT '3' NOT NULL;
ALTER TABLE stories add perm_group tinyint(1) unsigned DEFAULT '3' NOT NULL;
ALTER TABLE stories add perm_members tinyint(1) unsigned DEFAULT '2' NOT NULL;
ALTER TABLE stories add perm_anon tinyint(1) unsigned DEFAULT '2' NOT NULL;

#
# Table modifications for table 'pollquestions'
#

ALTER TABLE pollquestions add owner_id mediumint(8) unsigned DEFAULT '0' NOT NULL;
ALTER TABLE pollquestions add group_id mediumint(8) unsigned DEFAULT '1' NOT NULL;
ALTER TABLE pollquestions add perm_owner tinyint(1) unsigned DEFAULT '3' NOT NULL;
ALTER TABLE pollquestions add perm_group tinyint(1) unsigned DEFAULT '3' NOT NULL;
ALTER TABLE pollquestions add perm_members tinyint(1) unsigned DEFAULT '2' NOT NULL;
ALTER TABLE pollquestions add perm_anon tinyint(1) unsigned DEFAULT '2' NOT NULL;

#
# Table modifications for table 'users'
#

ALTER TABLE users add regdate datetime DEFAULT '0000-00-00 00:00:00' NOT NULL;
ALTER TABLE users add cookietimeout int(8) unsigned DEFAULT NULL;
UPDATE users SET regdate = NOW();

#
# Table structure for table 'wordlist'
#

CREATE TABLE wordlist (
   wid mediumint(8) unsigned NOT NULL auto_increment,
   word varchar(255) NOT NULL,
   replaceword varchar(255) NOT NULL,
   PRIMARY KEY (wid)
);

