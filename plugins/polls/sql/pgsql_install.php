<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Polls Plugin 2.1                                                          |
// +---------------------------------------------------------------------------+
// | mysql_install.php                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Trinity Bays      - trinity93 AT gmail DOT com
// |          Stansislav Palatnik - spalatnikk AT gmail DOT com                    |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is licensed under the terms of the GNU General Public License|
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                      |
// | See the GNU General Public License for more details.                      |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

/**
* MySQL install data and tables
*
* @package Polls
*/

$_SQL[] = "
CREATE TABLE {$_TABLES['pollanswers']} (
  pid varchar(40) NOT NULL default '',
  qid int NOT NULL default 0,
  aid int NOT NULL default '0',
  answer varchar(255) default NULL,
  votes int default NULL,
  remark varchar(255) NULL,
  PRIMARY KEY (pid, qid, aid)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['pollquestions']} (
  qid int NOT NULL DEFAULT '0',
  pid varchar(40) NOT NULL default '',
  question varchar(255) NOT NULL,
  PRIMARY KEY (qid, pid)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['polltopics']} (
  pid varchar(40) NOT NULL default '',
  topic varchar(255) default NULL,
  voters int default NULL,
  questions int NOT NULL default '0',
  date timestamp default NULL,
  display int NOT NULL default '0',
  is_open int NOT NULL default '1',
  hideresults int NOT NULL default '0',
  commentcode int NOT NULL default '0',
  statuscode int NOT NULL default '0',
  owner_id int  NOT NULL default '1',
  group_id int  NOT NULL default '1',
  perm_owner int  NOT NULL default '3',
  perm_group int  NOT NULL default '2',
  perm_members int  NOT NULL default '2',
  perm_anon int  NOT NULL default '2',
  PRIMARY KEY  (pid));
  CREATE INDEX  pollquestions_qid ON {$_TABLES['polltopics']}(pid);
  CREATE INDEX pollquestions_date ON {$_TABLES['polltopics']}(date);
  CREATE INDEX pollquestions_display ON {$_TABLES['polltopics']}(display);
  CREATE INDEX pollquestions_commentcode ON {$_TABLES['polltopics']}(commentcode);
  CREATE INDEX pollquestions_statuscode ON {$_TABLES['polltopics']}(statuscode);

";

$_SQL[] = "
CREATE TABLE {$_TABLES['pollvoters']} (
  id SERIAL,
  pid varchar(20) NOT NULL,
  ipaddress varchar(15) NOT NULL default '',
  date int default NULL,
  PRIMARY KEY  (id)
)
";

$_SQL[] = "INSERT INTO {$_TABLES['blocks']} (bid,is_enabled, name, type, title, tid, blockorder, content, onleft, phpblockfn, owner_id, group_id, perm_owner, perm_group) VALUES ((SELECT NEXTVAL('bid_seq')),1,'polls_block','phpblock','Poll','all',30,'',0,'phpblock_polls',{$_USER['uid']},#group#,3,3)";


// default poll

$DEFVALUES[] = "INSERT INTO {$_TABLES['polltopics']} (pid, topic, voters, questions, date, display, is_open, hideresults, commentcode, statuscode, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('geeklogfeaturepoll', 'Tell us your opinion about Geeklog', 0, 2, NOW(), 1, 1, 1, 0, 0, {$_USER['uid']}, #group#, 3, 2, 2, 2);";

$DEFVALUES[] = "INSERT INTO {$_TABLES['pollquestions']} (qid, pid, question) VALUES (0, 'geeklogfeaturepoll', 'What is the best new feature of Geeklog?');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollquestions']} (qid, pid, question) VALUES (1, 'geeklogfeaturepoll', 'What is the all-time best feature of Geeklog?');";

$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 0, 1, 'MS SQL support', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 0, 2, 'Multi-language support', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 0, 3, 'Calendar as a plugin', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 0, 4, 'SLV spam protection', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 0, 5, 'Mass-delete users', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 0, 6, 'Other', 0, '');";

$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 1, 1, 'Permissions Handling', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 1, 2, 'Spam Protection', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 1, 3, 'Focus on Security', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 1, 4, 'Plugin Availability', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 1, 5, 'The Community', 0, '');";

?>
