# MySQL dump 8.14
#
# Host: localhost    Database: geeklog
#--------------------------------------------------------
# Server version	3.23.41

#
# Dumping data for table 'access'
#

INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (1,3);
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (2,3);
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (3,5);
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (4,5);
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (5,9);
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (5,11);
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (6,9);
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (6,11);
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (8,7);
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (9,7);
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (10,4);
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (11,6);
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (12,8);
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (13,10);
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (14,11);
INSERT INTO access (acc_ft_id, acc_grp_id) VALUES (15,11);

#
# Dumping data for table 'blocks'
#

INSERT INTO blocks (bid, title, tid, blockorder, type, rdfurl, rdfupdated, content, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon, name) VALUES (3,'User Block','all',2,'gldefault','','0000-00-00 00:00:00','',1,'',1,2,3,3,2,2,'user_block');
INSERT INTO blocks (bid, title, tid, blockorder, type, rdfurl, rdfupdated, content, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon, name) VALUES (4,'Admin Block','all',1,'gldefault','','0000-00-00 00:00:00','',1,'',1,2,3,3,2,2,'admin_block');
INSERT INTO blocks (bid, title, tid, blockorder, type, rdfurl, rdfupdated, content, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon, name) VALUES (5,'Section Block','all',0,'gldefault','','0000-00-00 00:00:00','',1,'',1,2,3,3,2,2,'section_block');
INSERT INTO blocks (bid, title, tid, blockorder, type, rdfurl, rdfupdated, content, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon, name) VALUES (6,'Poll Block','all',2,'gldefault','','0000-00-00 00:00:00','',0,'0',1,2,3,3,2,2,'poll_block');
INSERT INTO blocks (bid, title, tid, blockorder, type, rdfurl, rdfupdated, content, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon, name) VALUES (7,'Events Block','all',3,'gldefault','','0000-00-00 00:00:00','',1,'',1,2,3,3,2,2,'events_block');
INSERT INTO blocks (bid, title, tid, blockorder, type, rdfurl, rdfupdated, content, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon, name) VALUES (8,'Whats New Block','all',3,'gldefault','','0000-00-00 00:00:00','',0,'1',1,2,3,3,2,2,'whats_new_block');
INSERT INTO blocks (bid, title, tid, blockorder, type, rdfurl, rdfupdated, content, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon, name) VALUES (9,'GeekLog 1.3','all',1,'normal','','0000-00-00 00:00:00','Welcome to GeekLog 1.3!  There have been many improvments to GeekLog since 1.2.5-1, namely the addition of plug-in support, improved security and themes.  Please read the release notes in the /docs directory and go over the install guide.',0,'',4,2,3,3,2,2,'first_block');
INSERT INTO blocks (bid, title, tid, blockorder, type, rdfurl, rdfupdated, content, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon, name) VALUES (10,'User Rights','all',5,'phpblock','','0000-00-00 00:00:00','',1,'phpblock_showrights',4,7,3,3,2,2,'security_rights_block');

#
# Dumping data for table 'commentcodes'
#

INSERT INTO commentcodes (code, name) VALUES (0,'Comments Enabled');
INSERT INTO commentcodes (code, name) VALUES (1,'Read-Only');
INSERT INTO commentcodes (code, name) VALUES (-1,'Comments Disabled');

#
# Dumping data for table 'commentmodes'
#

INSERT INTO commentmodes (mode, name) VALUES ('flat','Flat');
INSERT INTO commentmodes (mode, name) VALUES ('nested','Nested');
INSERT INTO commentmodes (mode, name) VALUES ('threaded','Threaded');
INSERT INTO commentmodes (mode, name) VALUES ('nocomment','No Comments');

#
# Dumping data for table 'comments'
#

INSERT INTO comments (cid, sid, date, title, comment, score, reason, pid, uid) VALUES (21,'geeklogpollquestion','2001-07-19 14:44:54','I love Geeklog!','I can\'t make up my mind...I love it all!',0,0,0,1);
INSERT INTO comments (cid, sid, date, title, comment, score, reason, pid, uid) VALUES (22,'geeklogpollquestion','2001-07-19 14:48:23','We are glad you like it!','We are happy you like Geeklog.  Please be sure to join the <a   href=http://lists.sourceforge.net/lists/listinfo/geeklog-devel target=_new>geeklog mailing</a> list!',0,0,21,2);
INSERT INTO comments (cid, sid, date, title, comment, score, reason, pid, uid) VALUES (23,'20010719095630103','2001-07-19 15:02:57','Other Admin accounts','Remember, the admin accounts that come with a fresh Geeklog installation are for demonstration purposes only.  You should delete them if you don\'t plan on using them or at least change their passwords.',0,0,0,2);

#
# Dumping data for table 'commentspeedlimit'
#


#
# Dumping data for table 'cookiecodes'
#

INSERT INTO cookiecodes (cc_value, cc_descr) VALUES (3600,'1 Hour');
INSERT INTO cookiecodes (cc_value, cc_descr) VALUES (7200,'2 Hours');
INSERT INTO cookiecodes (cc_value, cc_descr) VALUES (10800,'3 Hours');
INSERT INTO cookiecodes (cc_value, cc_descr) VALUES (28800,'8 Hours');
INSERT INTO cookiecodes (cc_value, cc_descr) VALUES (86400,'1 Day');
INSERT INTO cookiecodes (cc_value, cc_descr) VALUES (604800,'1 Week');
INSERT INTO cookiecodes (cc_value, cc_descr) VALUES (2678400,'1 Month');
INSERT INTO cookiecodes (cc_value, cc_descr) VALUES (31536000,'1 Year');

#
# Dumping data for table 'dateformats'
#

INSERT INTO dateformats (dfid, format, description) VALUES (0,'','System Default');
INSERT INTO dateformats (dfid, format, description) VALUES (1,'%A %B %d, %Y @%I:%M%p','Sunday March 21, 1999 @10:00PM');
INSERT INTO dateformats (dfid, format, description) VALUES (2,'%A %b %d, %Y @%H:%M','Sunday March 21, 1999 @22:00');
INSERT INTO dateformats (dfid, format, description) VALUES (4,'%A %b %d @%H:%M','Sunday March 21 @22:00');
INSERT INTO dateformats (dfid, format, description) VALUES (5,'%H:%M %d %B %Y','22:00 21 March 1999');
INSERT INTO dateformats (dfid, format, description) VALUES (6,'%H:%M %A %d %B %Y','22:00 Sunday 21 March 1999');
INSERT INTO dateformats (dfid, format, description) VALUES (7,'%I:%M%p - %A %B %d %Y','10:00PM -- Sunday March 21 1999');
INSERT INTO dateformats (dfid, format, description) VALUES (8,'%a %B %d, %I:%M%p','Sun March 21, 10:00PM');
INSERT INTO dateformats (dfid, format, description) VALUES (9,'%a %B %d, %H:%M','Sun March 21, 22:00');
INSERT INTO dateformats (dfid, format, description) VALUES (10,'%m-%d-%y %H:%M','3-21-99 22:00');
INSERT INTO dateformats (dfid, format, description) VALUES (11,'%d-%m-%y %H:%M','21-3-99 22:00');
INSERT INTO dateformats (dfid, format, description) VALUES (12,'%m-%d-%y %I:%M%p','3-21-99 10:00PM');
INSERT INTO dateformats (dfid, format, description) VALUES (13,'%I:%M%p  %B %D, %Y','10:00PM  March 21st, 1999');
INSERT INTO dateformats (dfid, format, description) VALUES (14,'%a %b %d, \'%y %I:%M%p','Sun Mar 21, \'99 10:00PM');
INSERT INTO dateformats (dfid, format, description) VALUES (15,'Day %j, %I ish','Day 80, 10 ish');
INSERT INTO dateformats (dfid, format, description) VALUES (16,'%y-%m-%d %I:%M','99-03-21 10:00');
INSERT INTO dateformats (dfid, format, description) VALUES (17,'%d/%m/%y %H:%M','21/03/99 22:00');
INSERT INTO dateformats (dfid, format, description) VALUES (18,'%a %d %b %I:%M%p','Sun 21 Mar 10:00PM');

#
# Dumping data for table 'events'
#

INSERT INTO events (eid, title, description, location, datestart, dateend, url, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('20011003090039479','Testin this mug\'','Test','Testin this mug\'','2001-10-04','2001-10-04','',7,2,3,3,2,2);
INSERT INTO events (eid, title, description, location, datestart, dateend, url, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('20011030085351523','Des Moines, Iowa','Test','Des Moines, Iowa','2001-10-30','2001-10-30','http://www.tonybibbs.com',7,2,3,3,2,2);
INSERT INTO events (eid, title, description, location, datestart, dateend, url, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('20011101081539417','My Test Event','test','test	','2001-11-01','2001-11-02','http://www.tonybibbs.com',1,1,3,3,2,2);

#
# Dumping data for table 'eventsubmission'
#

INSERT INTO eventsubmission (eid, title, description, location, datestart, dateend, url) VALUES ('2001110114064662','Test event','test','Test','2001-11-02','2001-11-03','http://www.tonybibbs.com');

#
# Dumping data for table 'featurecodes'
#

INSERT INTO featurecodes (code, name) VALUES (0,'Not Featured');
INSERT INTO featurecodes (code, name) VALUES (1,'Featured');

#
# Dumping data for table 'features'
#

INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (1,'story.edit','Access to story editor',1);
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (2,'story.moderate','Ablility to moderate pending stories',1);
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (3,'link.moderate','Ablility to moderate pending links',1);
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (4,'link.edit','Access to link editor',1);
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (5,'user.edit','Access to user editor',1);
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (6,'user.delete','Ablility to delete a user',1);
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (7,'user.mail','Ablility to send email to members',1);
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (8,'event.moderate','Ablility to moderate pending events',1);
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (9,'event.edit','Access to event editor',1);
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (10,'block.edit','Access to block editor',1);
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (11,'topic.edit','Access to topic editor',1);
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (12,'poll.edit','Access to poll editor',1);
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (13,'plugin.edit','Access to plugin editor',1);
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (14,'group.edit','Ability to edit groups',1);
INSERT INTO features (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (15,'group.delete','Ability to delete groups',1);

#
# Dumping data for table 'frontpagecodes'
#

INSERT INTO frontpagecodes (code, name) VALUES (0,'Show Only in Topic');
INSERT INTO frontpagecodes (code, name) VALUES (1,'Show on Front Page');

#
# Dumping data for table 'group_assignments'
#

INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,1,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,1);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (3,NULL,1);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (4,NULL,1);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (5,NULL,1);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (6,NULL,1);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (7,NULL,1);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (8,NULL,1);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,NULL,1);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (10,NULL,1);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (11,NULL,1);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,2,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (12,2,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (11,2,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,12);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,10);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,9);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,8);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,7);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,6);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,5);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,4);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,3);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (12,NULL,1);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,NULL,11);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,11);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (7,9,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (8,5,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (5,8,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (6,6,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,10,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (12,11,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (3,12,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (3,3,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,5,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,6,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (4,7,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,8,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,9,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,10,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,11,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,12,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,3,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,7,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,3,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,5,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,6,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,7,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,8,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,9,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,10,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,11,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,12,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (11,13,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (1,NULL,14);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (10,2,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,2,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (8,2,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (7,2,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (6,2,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (5,2,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (4,2,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (3,2,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,2,NULL);
INSERT INTO group_assignments (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (1,2,NULL);

#
# Dumping data for table 'groups'
#

INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (1,'Root','Has full access to the site',1);
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (2,'All Users','Group that a typical user is added to',1);
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (3,'Story Admin','Has full access to story features',1);
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (4,'Block Admin','Has full access to block features',1);
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (5,'Link Admin','Has full access to link features',1);
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (6,'Topic Admin','Has full access to topic features',1);
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (7,'Event Admin','Has full access to event features',1);
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (8,'Poll Admin','Has full access to poll features',1);
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (9,'User Admin','Has full access to user features',1);
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (10,'Plugin Admin','Has full access to plugin features',1);
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (11,'Group Admin','Is a User Admin with Acces to Groups too',1);
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (12,'Mail Admin','Can Mail Utility',1);
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (13,'Logged-in Users','All users except anonymous should belong to this group',1);
INSERT INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (14,'Tonys Test Group','Testing',0);

#
# Dumping data for table 'links'
#

INSERT INTO links (lid, category, url, description, title, hits, date, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('20010719095147683','Geeklog Sites','http://www.geeklog.org','The source for stuff...nifty stuff','Geeklog.org',0,NULL,1,2,3,3,2,2);
INSERT INTO links (lid, category, url, description, title, hits, date, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('20010719095621775','Geeklog Sites','http://www.devgeek.org','The place to talk about and contribute to the development of Geeklog','DevGeek',78,NULL,1,2,3,3,2,0);
INSERT INTO links (lid, category, url, description, title, hits, date, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('2001071910450356','Geeklog Sites','http://www.iowaoutdoors.org','Your source for hunting and fishing information in Iowa.','Iowa Outdoors',0,NULL,5,2,3,3,2,2);

#
# Dumping data for table 'linksubmission'
#

INSERT INTO linksubmission (lid, category, url, description, title, hits, date) VALUES ('20011101140601418','Cool Sites','http://www.tonybibbs.com','Test','Tony Bibbs\\\' Homepage',NULL,NULL);

#
# Dumping data for table 'maillist'
#

INSERT INTO maillist (code, name) VALUES (0,'Don\'t Email');
INSERT INTO maillist (code, name) VALUES (1,'Email Headlines Each Night');

#
# Dumping data for table 'metars'
#

INSERT INTO metars (metar, timestamp, station) VALUES (' KDSM 081754Z 16018G24KT 10SM FEW150 OVC250 18/08 A3001 RMK AO2 PK WND 15027/1701 SLP162 T01830078 10183 20106 58016',20011008175400,'KDSM');

#
# Dumping data for table 'plugins'
#


#
# Dumping data for table 'pollanswers'
#

INSERT INTO pollanswers (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',4,'New Security Model',20);
INSERT INTO pollanswers (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',3,'Improved Calendar',11);
INSERT INTO pollanswers (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',2,'Plugin-Support',31);
INSERT INTO pollanswers (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',1,'User-Defined Themes',88);
INSERT INTO pollanswers (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',5,'Other',3);

#
# Dumping data for table 'pollquestions'
#

INSERT INTO pollquestions (qid, question, voters, date, display, commentcode, statuscode, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('geeklogfeaturepoll','What is the best new feature of Geeklog?',153,'2001-10-29 09:36:39',1,0,0,8,2,3,3,2,2);

#
# Dumping data for table 'pollvoters'
#


#
# Dumping data for table 'postmodes'
#

INSERT INTO postmodes (code, name) VALUES ('plaintext','Plain Old Text');
INSERT INTO postmodes (code, name) VALUES ('html','HTML Formatted');

#
# Dumping data for table 'sessions'
#

INSERT INTO sessions (sess_id, start_time, remote_ip, uid, md5_sess_id) VALUES (583297965,1004972399,'192.168.20.2',2,'');

#
# Dumping data for table 'sortcodes'
#

INSERT INTO sortcodes (code, name) VALUES ('ASC','Oldest First');
INSERT INTO sortcodes (code, name) VALUES ('DESC','Newest First');

#
# Dumping data for table 'statuscodes'
#

INSERT INTO statuscodes (code, name) VALUES (1,'Refreshing');
INSERT INTO statuscodes (code, name) VALUES (0,'Normal');
INSERT INTO statuscodes (code, name) VALUES (10,'Archive');

#
# Dumping data for table 'stories'
#

INSERT INTO stories (sid, uid, tid, title, introtext, bodytext, hits, date, comments, related, featured, commentcode, statuscode, postmode, frontpage, draft_flag, numemails, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('20010719095630103',2,'GeekLog','Welcome to Geeklog!','<p>Welcome and let me be the first to congratulate you on installing GeekLog. Please take the time to read everything in the docs directory. Geeklog now has enhanced, user-based security.  You should thoroughly understand how these work before you run a production Geeklog Site.\r\r<p>Below are a list of usernames that have access to a specific portion of the site with the exception of Admin who has access to everything.  The password for each account is <b>password</b>. \r\r<P>\r<ul>Accounts:\r<li>Admin</li>\r<li>StoryAdmin</li>\r<li>LinkAdmin</li>\r<li>BlockAdmin</li>\r<li>EventAdmin</li>\r<li>TopicAdmin</li>\r<li>MailAdmin</li>\r<li>PollAdmin</li>\r<li>UserAdmin</li>\r<li>GroupAdmin</li>\r</ul>','',172,'2001-07-19 09:56:30',1,'<li><a href=http://tbibbs/search.php?mode=search&type=stories&author=2>More by Admin</a><li><a href=http://tbibbs/search.php?mode=search&type=stories&topic=GeekLog>More from GeekLog</a>',1,0,0,'html',1,0,1,2,3,3,3,2,2);
INSERT INTO stories (sid, uid, tid, title, introtext, bodytext, hits, date, comments, related, featured, commentcode, statuscode, postmode, frontpage, draft_flag, numemails, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('20011029162602450',2,'GeekLog','Second Articles','This is a test','',172,'2001-11-01 16:50:08',0,'<li><a href=http://tbibbs/search.php?mode=search&type=stories&author=2>More by Admin</a><li><a href=http://tbibbs/search.php?mode=search&type=stories&topic=GeekLog>More from GeekLog</a>',0,0,0,'html',1,0,1,2,3,3,3,2,2);

#
# Dumping data for table 'storysubmission'
#

INSERT INTO storysubmission (sid, uid, tid, title, introtext, date, postmode) VALUES ('20011018120556538',2,'GeekLog','Test','Test','2001-10-18 12:05:56','html');

#
# Dumping data for table 'submitspeedlimit'
#


#
# Dumping data for table 'topics'
#

INSERT INTO topics (tid, topic, imageurl, sortnum, limitnews, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('General','General News','',1,10,2,2,3,3,2,3);
INSERT INTO topics (tid, topic, imageurl, sortnum, limitnews, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('GeekLog','GeekLog','/images/topics/topic_gl.gif',2,0,2,2,3,3,2,3);

#
# Dumping data for table 'tzcodes'
#

INSERT INTO tzcodes (tz, offset, description) VALUES ('ndt',-9000,'Newfoundland Daylight');
INSERT INTO tzcodes (tz, offset, description) VALUES ('adt',-10800,'Atlantic Daylight');
INSERT INTO tzcodes (tz, offset, description) VALUES ('edt',-14400,'Eastern Daylight');
INSERT INTO tzcodes (tz, offset, description) VALUES ('cdt',-18000,'Central Daylight');
INSERT INTO tzcodes (tz, offset, description) VALUES ('mdt',-21600,'Mountain Daylight');
INSERT INTO tzcodes (tz, offset, description) VALUES ('pdt',-25200,'Pacific Daylight');
INSERT INTO tzcodes (tz, offset, description) VALUES ('ydt',-28800,'Yukon Daylight');
INSERT INTO tzcodes (tz, offset, description) VALUES ('hdt',-32400,'Hawaii Daylight');
INSERT INTO tzcodes (tz, offset, description) VALUES ('bst',3600,'British Summer');
INSERT INTO tzcodes (tz, offset, description) VALUES ('mes',7200,'Middle European Summer');
INSERT INTO tzcodes (tz, offset, description) VALUES ('sst',7200,'Swedish Summer');
INSERT INTO tzcodes (tz, offset, description) VALUES ('fst',7200,'French Summer');
INSERT INTO tzcodes (tz, offset, description) VALUES ('wad',28800,'West Australian Daylight');
INSERT INTO tzcodes (tz, offset, description) VALUES ('cad',37800,'Central Australian Daylight');
INSERT INTO tzcodes (tz, offset, description) VALUES ('ead',39600,'Eastern Australian Daylight');
INSERT INTO tzcodes (tz, offset, description) VALUES ('nzd',46800,'New Zealand Daylight');
INSERT INTO tzcodes (tz, offset, description) VALUES ('gmt',0,'Greenwich Mean');
INSERT INTO tzcodes (tz, offset, description) VALUES ('utc',0,'Universal (Coordinated)');
INSERT INTO tzcodes (tz, offset, description) VALUES ('wet',0,'Western European');
INSERT INTO tzcodes (tz, offset, description) VALUES ('wat',-3600,'West Africa');
INSERT INTO tzcodes (tz, offset, description) VALUES ('at',-7200,'Azores');
INSERT INTO tzcodes (tz, offset, description) VALUES ('gst',-10800,'Greenland Standard');
INSERT INTO tzcodes (tz, offset, description) VALUES ('nft',-12600,'Newfoundland');
INSERT INTO tzcodes (tz, offset, description) VALUES ('nst',-12600,'Newfoundland Standard');
INSERT INTO tzcodes (tz, offset, description) VALUES ('ast',-14400,'Atlantic Standard');
INSERT INTO tzcodes (tz, offset, description) VALUES ('est',-18000,'Eastern Standard');
INSERT INTO tzcodes (tz, offset, description) VALUES ('cst',-21600,'Central Standard');
INSERT INTO tzcodes (tz, offset, description) VALUES ('mst',-25200,'Mountain Standard');
INSERT INTO tzcodes (tz, offset, description) VALUES ('pst',-28800,'Pacific Standard');
INSERT INTO tzcodes (tz, offset, description) VALUES ('yst',-32400,'Yukon Standard');
INSERT INTO tzcodes (tz, offset, description) VALUES ('hst',-36000,'Hawaii Standard');
INSERT INTO tzcodes (tz, offset, description) VALUES ('cat',-36000,'Central Alaska');
INSERT INTO tzcodes (tz, offset, description) VALUES ('ahs',-36000,'Alaska-Hawaii Standard');
INSERT INTO tzcodes (tz, offset, description) VALUES ('nt',-39600,'Nome');
INSERT INTO tzcodes (tz, offset, description) VALUES ('idl',-43200,'International Date Line West');
INSERT INTO tzcodes (tz, offset, description) VALUES ('cet',3600,'Central European');
INSERT INTO tzcodes (tz, offset, description) VALUES ('met',3600,'Middle European');
INSERT INTO tzcodes (tz, offset, description) VALUES ('mew',3600,'Middle European Winter');
INSERT INTO tzcodes (tz, offset, description) VALUES ('swt',3600,'Swedish Winter');
INSERT INTO tzcodes (tz, offset, description) VALUES ('fwt',3600,'French Winter');
INSERT INTO tzcodes (tz, offset, description) VALUES ('eet',7200,'Eastern Europe, USSR Zone 1');
INSERT INTO tzcodes (tz, offset, description) VALUES ('bt',10800,'Baghdad, USSR Zone 2');
INSERT INTO tzcodes (tz, offset, description) VALUES ('it',12600,'Iran');
INSERT INTO tzcodes (tz, offset, description) VALUES ('zp4',14400,'USSR Zone 3');
INSERT INTO tzcodes (tz, offset, description) VALUES ('zp5',18000,'USSR Zone 4');
INSERT INTO tzcodes (tz, offset, description) VALUES ('ist',19800,'Indian Standard');
INSERT INTO tzcodes (tz, offset, description) VALUES ('zp6',21600,'USSR Zone 5');
INSERT INTO tzcodes (tz, offset, description) VALUES ('was',25200,'West Australian Standard');
INSERT INTO tzcodes (tz, offset, description) VALUES ('jt',27000,'Java (3pm in Cronusland!)');
INSERT INTO tzcodes (tz, offset, description) VALUES ('cct',28800,'China Coast, USSR Zone 7');
INSERT INTO tzcodes (tz, offset, description) VALUES ('jst',32400,'Japan Standard, USSR Zone 8');
INSERT INTO tzcodes (tz, offset, description) VALUES ('cas',34200,'Central Australian Standard');
INSERT INTO tzcodes (tz, offset, description) VALUES ('eas',36000,'Eastern Australian Standard');
INSERT INTO tzcodes (tz, offset, description) VALUES ('nzt',43200,'New Zealand');
INSERT INTO tzcodes (tz, offset, description) VALUES ('nzs',43200,'New Zealand Standard');
INSERT INTO tzcodes (tz, offset, description) VALUES ('id2',43200,'International Date Line East');
INSERT INTO tzcodes (tz, offset, description) VALUES ('idt',10800,'Israel Daylight');
INSERT INTO tzcodes (tz, offset, description) VALUES ('iss',7200,'Israel Standard');

#
# Dumping data for table 'usercomment'
#

INSERT INTO usercomment (uid, commentmode, commentorder, commentlimit) VALUES (1,'nested','ASC',100);
INSERT INTO usercomment (uid, commentmode, commentorder, commentlimit) VALUES (-1,'threaded','ASC',100);
INSERT INTO usercomment (uid, commentmode, commentorder, commentlimit) VALUES (2,'threaded','ASC',100);
INSERT INTO usercomment (uid, commentmode, commentorder, commentlimit) VALUES (3,'threaded','ASC',100);
INSERT INTO usercomment (uid, commentmode, commentorder, commentlimit) VALUES (0,'threaded','ASC',100);
INSERT INTO usercomment (uid, commentmode, commentorder, commentlimit) VALUES (4,'threaded','ASC',100);
INSERT INTO usercomment (uid, commentmode, commentorder, commentlimit) VALUES (5,'threaded','ASC',100);
INSERT INTO usercomment (uid, commentmode, commentorder, commentlimit) VALUES (8,'threaded','ASC',100);
INSERT INTO usercomment (uid, commentmode, commentorder, commentlimit) VALUES (6,'threaded','ASC',100);
INSERT INTO usercomment (uid, commentmode, commentorder, commentlimit) VALUES (7,'threaded','ASC',100);
INSERT INTO usercomment (uid, commentmode, commentorder, commentlimit) VALUES (9,'threaded','ASC',100);
INSERT INTO usercomment (uid, commentmode, commentorder, commentlimit) VALUES (10,'threaded','ASC',100);
INSERT INTO usercomment (uid, commentmode, commentorder, commentlimit) VALUES (11,'threaded','ASC',100);
INSERT INTO usercomment (uid, commentmode, commentorder, commentlimit) VALUES (12,'threaded','ASC',100);
INSERT INTO usercomment (uid, commentmode, commentorder, commentlimit) VALUES (13,'threaded','ASC',100);

#
# Dumping data for table 'userevent'
#

INSERT INTO userevent (uid, eid) VALUES (2,'20011101081539417');

#
# Dumping data for table 'userindex'
#

INSERT INTO userindex (uid, tids, aids, boxes, noboxes, maxstories) VALUES (-1,'','','',0,NULL);
INSERT INTO userindex (uid, tids, aids, boxes, noboxes, maxstories) VALUES (1,'','','',0,NULL);
INSERT INTO userindex (uid, tids, aids, boxes, noboxes, maxstories) VALUES (2,'','','',0,5);
INSERT INTO userindex (uid, tids, aids, boxes, noboxes, maxstories) VALUES (3,'','','',0,NULL);
INSERT INTO userindex (uid, tids, aids, boxes, noboxes, maxstories) VALUES (5,'','','',0,NULL);
INSERT INTO userindex (uid, tids, aids, boxes, noboxes, maxstories) VALUES (0,'','','',0,NULL);
INSERT INTO userindex (uid, tids, aids, boxes, noboxes, maxstories) VALUES (4,'','','',0,NULL);
INSERT INTO userindex (uid, tids, aids, boxes, noboxes, maxstories) VALUES (8,'','','',0,NULL);
INSERT INTO userindex (uid, tids, aids, boxes, noboxes, maxstories) VALUES (6,'','','',0,NULL);
INSERT INTO userindex (uid, tids, aids, boxes, noboxes, maxstories) VALUES (7,'','','',0,NULL);
INSERT INTO userindex (uid, tids, aids, boxes, noboxes, maxstories) VALUES (9,'','','',0,NULL);
INSERT INTO userindex (uid, tids, aids, boxes, noboxes, maxstories) VALUES (10,'','','',0,NULL);
INSERT INTO userindex (uid, tids, aids, boxes, noboxes, maxstories) VALUES (11,'','','',0,NULL);
INSERT INTO userindex (uid, tids, aids, boxes, noboxes, maxstories) VALUES (12,'','','',0,NULL);
INSERT INTO userindex (uid, tids, aids, boxes, noboxes, maxstories) VALUES (13,'','','',0,NULL);

#
# Dumping data for table 'userinfo'
#

INSERT INTO userinfo (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (1,'Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner ','','',0,0,0);
INSERT INTO userinfo (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (-1,NULL,NULL,'',0,0,0);
INSERT INTO userinfo (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (2,NULL,NULL,'',0,0,0);
INSERT INTO userinfo (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (3,NULL,NULL,'',0,0,0);
INSERT INTO userinfo (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (5,NULL,NULL,'',0,0,0);
INSERT INTO userinfo (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (0,NULL,NULL,'',0,0,0);
INSERT INTO userinfo (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (4,NULL,NULL,'',0,0,0);
INSERT INTO userinfo (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (8,NULL,NULL,'',0,0,0);
INSERT INTO userinfo (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (6,NULL,NULL,'',0,0,0);
INSERT INTO userinfo (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (7,NULL,NULL,'',0,0,0);
INSERT INTO userinfo (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (9,NULL,NULL,'',0,0,0);
INSERT INTO userinfo (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (10,NULL,NULL,'',0,0,0);
INSERT INTO userinfo (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (11,NULL,NULL,'',0,0,0);
INSERT INTO userinfo (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (12,NULL,NULL,'',0,0,0);
INSERT INTO userinfo (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (13,NULL,NULL,'',0,0,0);

#
# Dumping data for table 'userprefs'
#

INSERT INTO userprefs (uid, noicons, willing, dfid, tzid, emailstories) VALUES (1,0,0,0,'',0);
INSERT INTO userprefs (uid, noicons, willing, dfid, tzid, emailstories) VALUES (2,0,0,0,'',1);
INSERT INTO userprefs (uid, noicons, willing, dfid, tzid, emailstories) VALUES (3,0,1,0,'edt',1);
INSERT INTO userprefs (uid, noicons, willing, dfid, tzid, emailstories) VALUES (-1,0,1,0,'edt',1);
INSERT INTO userprefs (uid, noicons, willing, dfid, tzid, emailstories) VALUES (5,0,1,0,'edt',1);
INSERT INTO userprefs (uid, noicons, willing, dfid, tzid, emailstories) VALUES (0,0,1,0,'edt',1);
INSERT INTO userprefs (uid, noicons, willing, dfid, tzid, emailstories) VALUES (4,0,1,0,'edt',1);
INSERT INTO userprefs (uid, noicons, willing, dfid, tzid, emailstories) VALUES (8,0,1,0,'edt',1);
INSERT INTO userprefs (uid, noicons, willing, dfid, tzid, emailstories) VALUES (6,0,1,0,'edt',1);
INSERT INTO userprefs (uid, noicons, willing, dfid, tzid, emailstories) VALUES (7,0,1,0,'edt',1);
INSERT INTO userprefs (uid, noicons, willing, dfid, tzid, emailstories) VALUES (9,0,1,0,'edt',1);
INSERT INTO userprefs (uid, noicons, willing, dfid, tzid, emailstories) VALUES (10,0,1,0,'edt',1);
INSERT INTO userprefs (uid, noicons, willing, dfid, tzid, emailstories) VALUES (11,0,1,0,'edt',1);
INSERT INTO userprefs (uid, noicons, willing, dfid, tzid, emailstories) VALUES (12,0,1,0,'edt',1);
INSERT INTO userprefs (uid, noicons, willing, dfid, tzid, emailstories) VALUES (13,0,1,0,'edt',1);

#
# Dumping data for table 'users'
#

INSERT INTO users (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (1,'Anonymous','Anonymous','',NULL,NULL,'','2001-09-28 13:36:52',0,NULL);
INSERT INTO users (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (2,'Admin','Geeklog SuperUser','5f4dcc3b5aa765d61d8327deb882cf99','tony@tonybibbs.com','http://www.tonybibbs.com','','0000-00-00 00:00:00',0,'Yahoo');
INSERT INTO users (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (3,'StoryAdmin','Story Admin','5f4dcc3b5aa765d61d8327deb882cf99','root','http://geeklog.sourceforge.net','','2001-09-28 13:36:56',NULL,NULL);
INSERT INTO users (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (5,'PollAdmin','Poll Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','','2001-09-28 13:36:56',NULL,NULL);
INSERT INTO users (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (6,'TopicAdmin','Topic Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','','2001-09-28 13:36:56',NULL,NULL);
INSERT INTO users (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (7,'BlockAdmin','Block Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','','2001-09-28 13:36:56',NULL,NULL);
INSERT INTO users (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (8,'LinkAdmin','Link Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','','2001-09-28 13:36:56',NULL,NULL);
INSERT INTO users (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (9,'EventAdmin','Event Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','','2001-09-28 13:36:56',NULL,NULL);
INSERT INTO users (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (10,'UserAdmin','User Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','','2001-09-28 13:36:56',NULL,NULL);
INSERT INTO users (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (11,'MailAdmin','Mail Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','','2001-09-28 13:36:56',NULL,NULL);
INSERT INTO users (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (12,'StoryAdmin2','2nd Story Admin so you can test','5f4dcc3b5aa765d61d8327deb882cf99','root','','','2001-09-28 13:36:56',NULL,NULL);
INSERT INTO users (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (13,'GroupAdmin','Group Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','','2001-09-28 13:36:56',NULL,NULL);

#
# Dumping data for table 'vars'
#

INSERT INTO vars (name, value) VALUES ('totalhits','172');
INSERT INTO vars (name, value) VALUES ('lastemailedstories','2001-09-26 19:17:13');

#
# Dumping data for table 'wordlist'
#

INSERT INTO wordlist (wid, word, replaceword) VALUES (1,'fuck','*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES (2,'cunt','*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES (3,'fucker','*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES (4,'fucking','*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES (5,'pussy','*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES (6,'cock','*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES (7,'cum','*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES (8,'twat','*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES (9,'bitch','*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES (10,'motherfucker','*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES (11,'bastard','*censored*');

