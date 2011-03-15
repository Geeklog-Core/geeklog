<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Polls Plugin 2.1                                                          |
// +---------------------------------------------------------------------------+
// | mysql_install.php                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Trinity Bays      - trinity93 AT gmail DOT com                   |
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
  qid mediumint(9) NOT NULL default 0,
  aid tinyint(3) unsigned NOT NULL default '0',
  answer varchar(255) default NULL,
  votes mediumint(8) unsigned default NULL,
  remark varchar(255) NULL,
  PRIMARY KEY (pid, qid, aid)
) ENGINE=MyISAM
";

$_SQL[] = "
CREATE TABLE {$_TABLES['pollquestions']} (
  qid mediumint(9) NOT NULL DEFAULT '0',
  pid varchar(40) NOT NULL default '',
  question varchar(255) NOT NULL,
  PRIMARY KEY (qid, pid)
) ENGINE=MyISAM
";

$_SQL[] = "
CREATE TABLE {$_TABLES['polltopics']} (
  pid varchar(40) NOT NULL default '',
  topic varchar(255) default NULL,
  meta_description TEXT NULL,
  meta_keywords TEXT NULL,    
  voters mediumint(8) unsigned default NULL,
  questions int(11) NOT NULL default '0',
  `created` datetime default NULL,
  modified datetime default NULL,
  display tinyint(4) NOT NULL default '0',
  is_open tinyint(1) NOT NULL default '1',
  hideresults tinyint(1) NOT NULL default '0',
  commentcode tinyint(4) NOT NULL default '0',
  statuscode tinyint(4) NOT NULL default '0',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  group_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '2',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  INDEX pollquestions_qid(pid),
  INDEX pollquestions_created(created),
  INDEX pollquestions_display(display),
  INDEX pollquestions_commentcode(commentcode),
  INDEX pollquestions_statuscode(statuscode),
  PRIMARY KEY  (pid)
) ENGINE=MyISAM
";

$_SQL[] = "
CREATE TABLE {$_TABLES['pollvoters']} (
  id int(10) unsigned NOT NULL auto_increment,
  pid varchar(20) NOT NULL,
  ipaddress varchar(39) NOT NULL default '',
  date int(10) unsigned default NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM
";

$_SQL[] = "INSERT INTO {$_TABLES['blocks']} (is_enabled, name, type, title, tid, blockorder, content, onleft, phpblockfn, owner_id, group_id, perm_owner, perm_group) VALUES (1,'polls_block','phpblock','Poll','all',100,'',0,'phpblock_polls',{$_USER['uid']},#group#,3,3)";


// default poll

$DEFVALUES[] = "INSERT INTO {$_TABLES['polltopics']} (pid, topic, meta_description, meta_keywords, voters, questions, created, modified, display, is_open, hideresults, commentcode, statuscode, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('geeklogfeaturepoll', 'Tell us your opinion about Geeklog', 'A poll about users opinions of Geeklog.', 'Poll, Geeklog, Opinion', 0, 2, NOW(), NOW(), 1, 1, 1, 0, 0, {$_USER['uid']}, #group#, 3, 2, 2, 2);";

$DEFVALUES[] = "INSERT INTO {$_TABLES['pollquestions']} (qid, pid, question) VALUES (0, 'geeklogfeaturepoll', 'What is the best new feature of Geeklog?');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollquestions']} (qid, pid, question) VALUES (1, 'geeklogfeaturepoll', 'What is the all-time best feature of Geeklog?');";

$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 0, 1, 'OAuth Login Support', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 0, 2, 'New Configuration UI', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 0, 3, 'Plugin Dependencies', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 0, 4, 'Tooltips', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 0, 5, 'Other', 0, '');";

$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 1, 1, 'Permissions Handling', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 1, 2, 'Spam Protection', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 1, 3, 'Focus on Security', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 1, 4, 'Plugin Availability', 0, '');";
$DEFVALUES[] = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES ('geeklogfeaturepoll', 1, 5, 'The Community', 0, '');";

?>
