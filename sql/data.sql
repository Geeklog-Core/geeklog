#
# Dumping data for table 'blocks'
#

INSERT INTO blocks VALUES (9,'GeekLog 1.3','all',1,'normal','','0000-00-00 00:00:00','Welcome to GeekLog 1.3!  There have been many improvments to GeekLog since 1.2.5-1, namely the addition of plug-in support, improved security and themes.  Please read the release notes in the /docs directory and go over the install guide.',0,'',4,2,3,3,2,2);
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

INSERT INTO pollquestions VALUES ('geeklogpollquestion','What is the best feature of Geeklog?',66,'2001-09-28 13:25:34',1,0,1,8,2,3,3,2,2);

#
# Dumping data for table 'pollanswers'
#

INSERT INTO pollanswers VALUES ('geeklogpollquestion',1,'Administration Tools',12);
INSERT INTO pollanswers VALUES ('geeklogpollquestion',2,'Calendar',5);
INSERT INTO pollanswers VALUES ('geeklogpollquestion',3,'Polls',20);
INSERT INTO pollanswers VALUES ('geeklogpollquestion',4,'Security',7);
INSERT INTO pollanswers VALUES ('geeklogpollquestion',5,'Plugin Support',8);
INSERT INTO pollanswers VALUES ('geeklogpollquestion',6,'Themes/Templates',10);
INSERT INTO pollanswers VALUES ('geeklogpollquestion',7,'Other',4);

#
# Dumping data for table 'stories'
#

INSERT INTO stories VALUES ('20010719095630103',2,'GeekLog','Welcome to Geeklog!','<p>Welcome and let me be the first to congratulate you on installing GeekLog. Please take the time to read everything in the docs directory. Geeklog now has enhanced, group-based security.  You should thoroughly understand how these work before you run a production Geeklog Site.\r\r<p>Below are a list of usernames that have access to a specific portion of the site with the exception of Admin who has access to everything.  The password for each account is <b>password</b>. \r\r<P>\r<ul>Accounts:\r<li>StoryAdmin</li>\r<li>LinkAdmin</li>\r<li>BlockAdmin</li>\r<li>EventAdmin</li>\r<li>TopicAdmin</li>\r<li>MailAdmin</li>\r<li>PollAdmin</li>\r<li>UserAdmin</li>\r<li>GroupAdmin</li>\r</ul>','',33,'2001-07-19 09:56:30',1,'<li><a href=http://tbibbs/search.php?mode=search&type=stories&author=2>More by Admin</a><li><a href=http://tbibbs/search.php?mode=search&type=stories&topic=GeekLog>More from GeekLog</a>',1,0,0,'html',1,0,1,2,2,3,3,2,2);

#
# Dumping data for table 'topics'
# 
  
INSERT INTO topics VALUES ('General','General News','',1,10,2,2,3,3,2,3);
INSERT INTO topics VALUES ('GeekLog','GeekLog','/images/topics/topic_gl.gif',2,NULL,2,2,3,3,2,2);

#
# Dumping data for table 'users'
#

INSERT INTO users VALUES (3,'StoryAdmin','Story Admin','5f4dcc3b5aa765d61d8327deb882cf99','root','http://geeklog.sourceforge.net','',NOW(),NULL);
INSERT INTO users VALUES (5,'PollAdmin','Poll Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','',NOW(),NULL);
INSERT INTO users VALUES (6,'TopicAdmin','Topic Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','',NOW(),NULL);
INSERT INTO users VALUES (7,'BlockAdmin','Block Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','',NOW(),NULL);
INSERT INTO users VALUES (8,'LinkAdmin','Link Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','',NOW(),NULL);
INSERT INTO users VALUES (9,'EventAdmin','Event Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','',NOW(),NULL);
INSERT INTO users VALUES (10,'UserAdmin','User Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','',NOW(),NULL);
INSERT INTO users VALUES (11,'MailAdmin','Mail Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','',NOW(),NULL);
INSERT INTO users VALUES (12,'StoryAdmin2','2nd Story Admin so you can test','5f4dcc3b5aa765d61d8327deb882cf99','root','','',NOW(),NULL);
INSERT INTO users VALUES (13,'GroupAdmin','Group Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','',NOW(),NULL);

#
# Dumping data for table 'group_assignments'
#

INSERT INTO group_assignments VALUES (7,9,NULL);
INSERT INTO group_assignments VALUES (8,5,NULL);
INSERT INTO group_assignments VALUES (5,8,NULL);
INSERT INTO group_assignments VALUES (6,6,NULL);
INSERT INTO group_assignments VALUES (9,10,NULL);
INSERT INTO group_assignments VALUES (12,11,NULL);
INSERT INTO group_assignments VALUES (3,12,NULL);
INSERT INTO group_assignments VALUES (3,3,NULL);
INSERT INTO group_assignments VALUES (2,5,NULL);
INSERT INTO group_assignments VALUES (2,6,NULL);
INSERT INTO group_assignments VALUES (4,7,NULL);
INSERT INTO group_assignments VALUES (2,8,NULL);
INSERT INTO group_assignments VALUES (2,9,NULL);
INSERT INTO group_assignments VALUES (2,10,NULL);
INSERT INTO group_assignments VALUES (2,11,NULL);
INSERT INTO group_assignments VALUES (2,12,NULL);
INSERT INTO group_assignments VALUES (2,3,NULL);
INSERT INTO group_assignments VALUES (2,7,NULL);
INSERT INTO group_assignments VALUES (13,3,NULL);
INSERT INTO group_assignments VALUES (13,5,NULL);
INSERT INTO group_assignments VALUES (13,6,NULL);
INSERT INTO group_assignments VALUES (13,7,NULL);
INSERT INTO group_assignments VALUES (13,8,NULL);
INSERT INTO group_assignments VALUES (13,9,NULL);
INSERT INTO group_assignments VALUES (13,10,NULL);
INSERT INTO group_assignments VALUES (13,11,NULL);
INSERT INTO group_assignments VALUES (13,12,NULL);
INSERT INTO group_assignments VALUES (11,13,NULL);

#
# Dumping data for table 'wordlist'
#

INSERT INTO wordlist (wid, word, replaceword) VALUES ( '1', 'fuck', '*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES ( '2', 'cunt', '*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES ( '3', 'fucker', '*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES ( '4', 'fucking', '*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES ( '5', 'pussy', '*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES ( '6', 'cock', '*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES ( '7', 'cum', '*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES ( '8', 'twat', '*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES ( '9', 'bitch', '*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES ( '10', 'motherfucker', '*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES ( '11', 'bastard', '*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES ( '12', 'shit', '*censored*');
INSERT INTO wordlist (wid, word, replaceword) VALUES ( '13', 'Geeklog', '<b><a href=http://geeklog.sf.net>Geeklog</a></b>');

