# MySQL dump 7.1
#
# Host: localhost    Database: gldevel
#--------------------------------------------------------
# Server version	3.22.32

#
# Dumping data for table 'blocks'
#

INSERT INTO blocks VALUES (9,'GeekLog 1.3','all',200,0,'normal','','0000-00-00 00:00:00','Welcome to GeekLog 1.3!  There have been many improvments to GeekLog since 1.2.2, namely the addition of plug-in support.  Please read the release notes in the /docs directory and go over the install guide.',0,'');

#
# Dumping data for table 'commentcodes'
#

INSERT INTO commentcodes VALUES (0,'Comments Enabled');
INSERT INTO commentcodes VALUES (1,'Read-Only');
INSERT INTO commentcodes VALUES (-1,'Comments Disabled');

#
# Dumping data for table 'commentmodes'
#

INSERT INTO commentmodes VALUES ('flat','Flat');
INSERT INTO commentmodes VALUES ('nested','Nested');
INSERT INTO commentmodes VALUES ('threaded','Threaded');
INSERT INTO commentmodes VALUES ('nocomment','No Comments');

#
# Dumping data for table 'comments'
#

INSERT INTO comments VALUES (21,'geeklogpollquestion','2001-07-19 14:44:54','I love Geeklog!','I can\'t make up my mind...I love it all!',0,0,0,1);
INSERT INTO comments VALUES (22,'geeklogpollquestion','2001-07-19 14:48:23','We are glad you like it!','We are happy you like Geeklog.  Please be sure to join the <a   href=http://lists.sourceforge.net/lists/listinfo/geeklog-devel target=_new>geeklog mailing</a> list!',0,0,21,2);
INSERT INTO comments VALUES (23,'20010719095630103','2001-07-19 15:02:57','Other Admin accounts','Remember, the admin accounts that come with a fresh Geeklog installation are for demonstration purposes only.  You should delete them if you don\'t plan on using them or at least change their passwords.',0,0,0,2);
INSERT INTO comments VALUES (24,'20010719095630103','2001-07-19 15:07:14','Other Admin accounts','Thanks for the tip!',0,0,23,1);

#
# Dumping data for table 'commentspeedlimit'
#

INSERT INTO commentspeedlimit VALUES (1,'192.168.1.13',995557214);

#
# Dumping data for table 'dateformats'
#

INSERT INTO dateformats VALUES (0,'','System Default');
INSERT INTO dateformats VALUES (1,'%A %B %d, %Y @%I:%M%p','Sunday March 21, 1999 @10:00PM');
INSERT INTO dateformats VALUES (2,'%A %b %d, %Y @%H:%M','Sunday March 21, 1999 @22:00');
INSERT INTO dateformats VALUES (4,'%A %b %d @%H:%M','Sunday March 21 @22:00');
INSERT INTO dateformats VALUES (5,'%H:%M %d %B %Y','22:00 21 March 1999');
INSERT INTO dateformats VALUES (6,'%H:%M %A %d %B %Y','22:00 Sunday 21 March 1999');
INSERT INTO dateformats VALUES (7,'%I:%M%p - %A %B %d %Y','10:00PM -- Sunday March 21 1999');
INSERT INTO dateformats VALUES (8,'%a %B %d, %I:%M%p','Sun March 21, 10:00PM');
INSERT INTO dateformats VALUES (9,'%a %B %d, %H:%M','Sun March 21, 22:00');
INSERT INTO dateformats VALUES (10,'%m-%d-%y %H:%M','3-21-99 22:00');
INSERT INTO dateformats VALUES (11,'%d-%m-%y %H:%M','21-3-99 22:00');
INSERT INTO dateformats VALUES (12,'%m-%d-%y %I:%M%p','3-21-99 10:00PM');
INSERT INTO dateformats VALUES (13,'%I:%M%p  %B %D, %Y','10:00PM  March 21st, 1999');
INSERT INTO dateformats VALUES (14,'%a %b %d, \'%y %I:%M%p','Sun Mar 21, \'99 10:00PM');
INSERT INTO dateformats VALUES (15,'Day %j, %I ish','Day 80, 10 ish');
INSERT INTO dateformats VALUES (16,'%y-%m-%d %I:%M','99-03-21 10:00');
INSERT INTO dateformats VALUES (17,'%d/%m/%y %H:%M','21/03/99 22:00');
INSERT INTO dateformats VALUES (18,'%a %d %b %I:%M%p','Sun 21 Mar 10:00PM');

#
# Dumping data for table 'events'
#

INSERT INTO events VALUES ('20010719094844825','Geeklog Conference','The greatest geek convention on the planet!','Des Moines, Iowa','2001-08-01','2001-08-04','http://www.geeklog.org');

#
# Dumping data for table 'eventsubmission'
#


#
# Dumping data for table 'featurecodes'
#

INSERT INTO featurecodes VALUES (0,'Not Featured');
INSERT INTO featurecodes VALUES (1,'Featured');

#
# Dumping data for table 'frontpagecodes'
#

INSERT INTO frontpagecodes VALUES (0,'Show Only in Topic');
INSERT INTO frontpagecodes VALUES (1,'Show on Front Page');

#
# Dumping data for table 'links'
#

INSERT INTO links VALUES ('20010719095147683','Geeklog Sites','http://www.geeklog.org','The source for stuff...nifty stuff','Geeklog.org',122,NULL);
INSERT INTO links VALUES ('20010719095621775','Geeklog Sites','http://www.devgeek.org','The place to talk about and contribute to the development of Geeklog','DevGeek',78,NULL);
INSERT INTO links VALUES ('2001071910450356','Geeklog Sites','http://www.iowaoutdoors.org','Your source for hunting and fishing information in Iowa.','Iowa Outdoors',1234,NULL);

#
# Dumping data for table 'maillist'
#

INSERT INTO maillist VALUES (0,'Don\'t Email');
INSERT INTO maillist VALUES (1,'Email Headlines Each Night');

#
# Dumping data for table 'pollanswers'
#

INSERT INTO pollanswers VALUES ('geeklogpollquestion',3,'Polls',20);
INSERT INTO pollanswers VALUES ('geeklogpollquestion',2,'Calendar',5);
INSERT INTO pollanswers VALUES ('geeklogpollquestion',1,'Administration Tools',12);
INSERT INTO pollanswers VALUES ('geeklogpollquestion',4,'Other',7);

#
# Dumping data for table 'pollquestions'
#

INSERT INTO pollquestions VALUES ('geeklogpollquestion','What is the best feature of Geeklog?',44,'2001-07-19 09:43:50',1,0,1);

#
# Dumping data for table 'pollvoters'
#

#
# Dumping data for table 'postmodes'
#

INSERT INTO postmodes VALUES ('plaintext','Plain Old Text');
INSERT INTO postmodes VALUES ('html','HTML Formatted');

#
# Dumping data for table 'sessions'
#

INSERT INTO sessions VALUES (1645372305,995558846,'192.168.1.13',2,'29c362eba7e3d5bef7af93cafa531a58');

#
# Dumping data for table 'sortcodes'
#

INSERT INTO sortcodes VALUES ('ASC','Oldest First');
INSERT INTO sortcodes VALUES ('DESC','Newest First');

#
# Dumping data for table 'statuscodes'
#

INSERT INTO statuscodes VALUES (1,'Refreshing');
INSERT INTO statuscodes VALUES (0,'Normal');
INSERT INTO statuscodes VALUES (10,'Archive');

#
# Dumping data for table 'stories'
#

INSERT INTO stories VALUES ('20010719095630103',2,'GeekLog','Welcome to Geeklog!','Welcome and let me be the first to congratulate you on installing GeekLog. Please take the time to read everything in the docs directory. To log in to the admin section click <a      href=admin/index.php>here</a>. The default username and password for the admin is: <br><br><b>username:</b> Admin<br><b>password:</b> password','',20,'2001-07-19 09:56:30',2,'<li><a     href=admin/index.php>here</a><li><a  href=http://gldevel.iowaoutdoors.org/search.php?mode=search&type=stories&author=2>More by Admin</a>\n<li><a  href=http://gldevel.iowaoutdoors.org/search.php?mode=search&type=stories&topic=GeekLog>More from GeekLog</a>\n',1,0,0,'html',1,0);

#
# Dumping data for table 'submitspeedlimit'
#

INSERT INTO submitspeedlimit VALUES (1,'192.168.1.13',995550713);

#
# Dumping data for table 'topics'
#

INSERT INTO topics VALUES ('General','General News','',1,10);
INSERT INTO topics VALUES ('GeekLog','GeekLog','/images/topics/topic_gl.gif',2,NULL);

#
# Dumping data for table 'tzcodes'
#

INSERT INTO tzcodes VALUES ('ndt',-9000,'Newfoundland Daylight');
INSERT INTO tzcodes VALUES ('adt',-10800,'Atlantic Daylight');
INSERT INTO tzcodes VALUES ('edt',-14400,'Eastern Daylight');
INSERT INTO tzcodes VALUES ('cdt',-18000,'Central Daylight');
INSERT INTO tzcodes VALUES ('mdt',-21600,'Mountain Daylight');
INSERT INTO tzcodes VALUES ('pdt',-25200,'Pacific Daylight');
INSERT INTO tzcodes VALUES ('ydt',-28800,'Yukon Daylight');
INSERT INTO tzcodes VALUES ('hdt',-32400,'Hawaii Daylight');
INSERT INTO tzcodes VALUES ('bst',3600,'British Summer');
INSERT INTO tzcodes VALUES ('mes',7200,'Middle European Summer');
INSERT INTO tzcodes VALUES ('sst',7200,'Swedish Summer');
INSERT INTO tzcodes VALUES ('fst',7200,'French Summer');
INSERT INTO tzcodes VALUES ('wad',28800,'West Australian Daylight');
INSERT INTO tzcodes VALUES ('cad',37800,'Central Australian Daylight');
INSERT INTO tzcodes VALUES ('ead',39600,'Eastern Australian Daylight');
INSERT INTO tzcodes VALUES ('nzd',46800,'New Zealand Daylight');
INSERT INTO tzcodes VALUES ('gmt',0,'Greenwich Mean');
INSERT INTO tzcodes VALUES ('utc',0,'Universal (Coordinated)');
INSERT INTO tzcodes VALUES ('wet',0,'Western European');
INSERT INTO tzcodes VALUES ('wat',-3600,'West Africa');
INSERT INTO tzcodes VALUES ('at',-7200,'Azores');
INSERT INTO tzcodes VALUES ('gst',-10800,'Greenland Standard');
INSERT INTO tzcodes VALUES ('nft',-12600,'Newfoundland');
INSERT INTO tzcodes VALUES ('nst',-12600,'Newfoundland Standard');
INSERT INTO tzcodes VALUES ('ast',-14400,'Atlantic Standard');
INSERT INTO tzcodes VALUES ('est',-18000,'Eastern Standard');
INSERT INTO tzcodes VALUES ('cst',-21600,'Central Standard');
INSERT INTO tzcodes VALUES ('mst',-25200,'Mountain Standard');
INSERT INTO tzcodes VALUES ('pst',-28800,'Pacific Standard');
INSERT INTO tzcodes VALUES ('yst',-32400,'Yukon Standard');
INSERT INTO tzcodes VALUES ('hst',-36000,'Hawaii Standard');
INSERT INTO tzcodes VALUES ('cat',-36000,'Central Alaska');
INSERT INTO tzcodes VALUES ('ahs',-36000,'Alaska-Hawaii Standard');
INSERT INTO tzcodes VALUES ('nt',-39600,'Nome');
INSERT INTO tzcodes VALUES ('idl',-43200,'International Date Line West');
INSERT INTO tzcodes VALUES ('cet',3600,'Central European');
INSERT INTO tzcodes VALUES ('met',3600,'Middle European');
INSERT INTO tzcodes VALUES ('mew',3600,'Middle European Winter');
INSERT INTO tzcodes VALUES ('swt',3600,'Swedish Winter');
INSERT INTO tzcodes VALUES ('fwt',3600,'French Winter');
INSERT INTO tzcodes VALUES ('eet',7200,'Eastern Europe, USSR Zone 1');
INSERT INTO tzcodes VALUES ('bt',10800,'Baghdad, USSR Zone 2');
INSERT INTO tzcodes VALUES ('it',12600,'Iran');
INSERT INTO tzcodes VALUES ('zp4',14400,'USSR Zone 3');
INSERT INTO tzcodes VALUES ('zp5',18000,'USSR Zone 4');
INSERT INTO tzcodes VALUES ('ist',19800,'Indian Standard');
INSERT INTO tzcodes VALUES ('zp6',21600,'USSR Zone 5');
INSERT INTO tzcodes VALUES ('was',25200,'West Australian Standard');
INSERT INTO tzcodes VALUES ('jt',27000,'Java (3pm in Cronusland!)');
INSERT INTO tzcodes VALUES ('cct',28800,'China Coast, USSR Zone 7');
INSERT INTO tzcodes VALUES ('jst',32400,'Japan Standard, USSR Zone 8');
INSERT INTO tzcodes VALUES ('cas',34200,'Central Australian Standard');
INSERT INTO tzcodes VALUES ('eas',36000,'Eastern Australian Standard');
INSERT INTO tzcodes VALUES ('nzt',43200,'New Zealand');
INSERT INTO tzcodes VALUES ('nzs',43200,'New Zealand Standard');
INSERT INTO tzcodes VALUES ('id2',43200,'International Date Line East');
INSERT INTO tzcodes VALUES ('idt',10800,'Israel Daylight');
INSERT INTO tzcodes VALUES ('iss',7200,'Israel Standard');

#
# Dumping data for table 'usercomment'
#

INSERT INTO usercomment VALUES (1,'nested','ASC',100);
INSERT INTO usercomment VALUES (-1,'threaded','ASC',100);
INSERT INTO usercomment VALUES (2,'threaded','ASC',100);
INSERT INTO usercomment VALUES (3,'threaded','ASC',100);
INSERT INTO usercomment VALUES (0,'threaded','ASC',100);
INSERT INTO usercomment VALUES (4,'threaded','ASC',100);
INSERT INTO usercomment VALUES (5,'threaded','ASC',99);
INSERT INTO usercomment VALUES (8,'threaded','ASC',100);
INSERT INTO usercomment VALUES (6,'threaded','ASC',100);
INSERT INTO usercomment VALUES (7,'nested','ASC',100);
INSERT INTO usercomment VALUES (9,'threaded','ASC',100);
INSERT INTO usercomment VALUES (10,'threaded','ASC',100);

#
# Dumping data for table 'userevent'
#

INSERT INTO userevent VALUES (4,'20010717140232751');

#
# Dumping data for table 'userindex'
#

INSERT INTO userindex VALUES (-1,'','','',0,NULL);
INSERT INTO userindex VALUES (1,'','','',0,NULL);
INSERT INTO userindex VALUES (2,'','','',0,NULL);
INSERT INTO userindex VALUES (3,'','','',0,NULL);
INSERT INTO userindex VALUES (5,'','','1',0,10);
INSERT INTO userindex VALUES (0,'','','',0,NULL);
INSERT INTO userindex VALUES (4,'','','',0,NULL);
INSERT INTO userindex VALUES (8,'','','',0,NULL);
INSERT INTO userindex VALUES (6,'','','',0,NULL);
INSERT INTO userindex VALUES (7,'','','',0,NULL);
INSERT INTO userindex VALUES (9,'','','',0,NULL);
INSERT INTO userindex VALUES (10,'','','',0,NULL);

#
# Dumping data for table 'userinfo'
#

INSERT INTO userinfo VALUES (1,'Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner ','','',0,0,0);
INSERT INTO userinfo VALUES (-1,NULL,NULL,'',0,0,0);
INSERT INTO userinfo VALUES (2,NULL,NULL,'',0,0,0);
INSERT INTO userinfo VALUES (3,NULL,NULL,'',0,0,0);
INSERT INTO userinfo VALUES (5,'','','',0,0,0);
INSERT INTO userinfo VALUES (0,NULL,NULL,'',0,0,0);
INSERT INTO userinfo VALUES (4,NULL,NULL,'',0,0,0);
INSERT INTO userinfo VALUES (8,NULL,NULL,'',0,0,0);
INSERT INTO userinfo VALUES (6,NULL,NULL,'',0,0,0);
INSERT INTO userinfo VALUES (7,'','','',0,0,0);
INSERT INTO userinfo VALUES (9,NULL,NULL,'',0,0,0);
INSERT INTO userinfo VALUES (10,NULL,NULL,'',0,0,0);

#
# Dumping data for table 'userprefs'
#

INSERT INTO userprefs VALUES (1,0,0,0,'',0);
INSERT INTO userprefs VALUES (2,0,1,0,'edt',1);
INSERT INTO userprefs VALUES (3,0,1,0,'edt',1);
INSERT INTO userprefs VALUES (-1,0,1,0,'edt',1);
INSERT INTO userprefs VALUES (5,0,0,0,'',0);
INSERT INTO userprefs VALUES (0,0,1,0,'edt',1);
INSERT INTO userprefs VALUES (4,0,1,0,'edt',1);
INSERT INTO userprefs VALUES (8,0,1,0,'edt',1);
INSERT INTO userprefs VALUES (6,0,1,0,'edt',1);
INSERT INTO userprefs VALUES (7,0,1,0,'edt',0);
INSERT INTO userprefs VALUES (9,0,1,0,'edt',1);
INSERT INTO userprefs VALUES (10,0,1,0,'edt',1);

#
# Dumping data for table 'users'
#

INSERT INTO users VALUES (1,'Anonymous','Anonymous','',0,NULL,NULL,'');
INSERT INTO users VALUES (3,'Admin2','GeekLog Junior Admin Account','5f4dcc3b5aa765d61d8327deb882cf99',150,'root','http://geeklog.newsgeeks.com','');
INSERT INTO users VALUES (4,'Admin3','GeekLog Story Reporter Account','5f4dcc3b5aa765d61d8327deb882cf99',100,'root','http://geeklog.newsgeeks.com','');
INSERT INTO users VALUES (2,'Admin','Geeklog Admin Account','5f4dcc3b5aa765d61d8327deb882cf99',255,'root@localhost.com','http://www.geeklog.org','');

#
# Dumping data for table 'vars'
#

INSERT INTO vars VALUES ('totalhits','3178');
INSERT INTO vars VALUES ('lastemailedstories','2001-04-18 22:29:29');

