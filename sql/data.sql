#
# Dumping data for table 'blocks'
#

INSERT INTO blocks VALUES (9,'GeekLog 1.3','all',1,'normal','','0000-00-00 00:00:00','Welcome to GeekLog 1.3!  There have been many improvments to GeekLog since 1.2.2, namely the addition of plug-in support.  Please read the release notes in the /docs directory and go over the install guide.',0,'',4,2,3,3,2,0);
INSERT INTO blocks VALUES (10,'What you have access to','all',5,'phpblock','','0000-00-00 00:00:00','',1,'phpblock_showrights',4,7,3,3,2,2);

#
# Dumping data for table 'links'
#

INSERT INTO links VALUES ('20010719095147683','Geeklog Sites','http://www.geeklog.org','The source for stuff...nifty stuff','Geeklog.org',122,NULL,1,2,3,3,2,2);
INSERT INTO links VALUES ('20010719095621775','Geeklog Sites','http://www.devgeek.org','The place to talk about and contribute to the development of Geeklog','DevGeek',78,NULL,1,2,3,3,2,2);
INSERT INTO links VALUES ('2001071910450356','Geeklog Sites','http://www.iowaoutdoors.org','Your source for hunting and fishing information in Iowa.','Iowa Outdoors',1234,NULL,5,2,3,3,2,2);

#
# Dumping data for table 'pollquestions'
#

INSERT INTO pollquestions VALUES ('geeklogpollquestion','What is the best feature of Geeklog?',44,'2001-09-26 14:49:20',1,0,1,8,2,3,3,2,0);

#
# Dumping data for table 'pollanswers'
#

INSERT INTO pollanswers VALUES ('geeklogpollquestion',4,'Other',7);
INSERT INTO pollanswers VALUES ('geeklogpollquestion',3,'Polls',20);
INSERT INTO pollanswers VALUES ('geeklogpollquestion',2,'Calendar',5);
INSERT INTO pollanswers VALUES ('geeklogpollquestion',1,'Administration Tools',12);

#
# Dumping data for table 'stories'
#

INSERT INTO stories VALUES ('20010719095630103',2,'GeekLog','Welcome to Geeklog!','<p>Welcome and let me be the first to congratulate you on installing GeekLog. Please take the time to read everything in the docs directory. Geeklog now has enhanced, user-based security.  You should thoroughly understand how these work before you run a production Geeklog Site.\r\r<p>Below are a list of usernames that have access to a specific portion of the site with the exception of Admin who has access to everything.  The password for each account is <b>password</b>.  As of 9/20/01 you are not able to edit users/groups.  I will be working on this over the next couple of days.\r\r<P>\r<ul>Accounts:\r<li>StoryAdmin</li>\r<li>LinkAdmin</li>\r<li>BlockAdmin</li>\r<li>EventAdmin</li>\r<li>TopicAdmin</li>\r<li>MailAdmin</li>\r<li>PollAdmin</li>\r<li>UserAdmin</li>\r</ul>','',33,'2001-07-19 09:56:30',2,'<li><a href=http://tbibbs/search.php?mode=search&type=stories&author=2>More by Admin</a><li><a href=http://tbibbs/search.php?mode=search&type=stories&topic=GeekLog>More from GeekLog</a>',1,0,0,'html',1,0,1,2,2,3,3,2,2);

#
# Dumping data for table 'topics'
# 
  
INSERT INTO topics VALUES ('General','General News','',1,10,2,2,3,3,2,3);
INSERT INTO topics VALUES ('GeekLog','GeekLog','/images/topics/topic_gl.gif',2,NULL,2,2,3,3,2,2);

