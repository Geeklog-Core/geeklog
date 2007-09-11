<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Polls Plugin 1.0                                                          |
// +---------------------------------------------------------------------------+
// | Installation SQL                                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Trinity Bays      - trinity AT steubentech DOT com               |
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
//
// $Id: mysql_install.php,v 1.8 2007/09/11 05:28:11 ospiess Exp $

$_SQL[] = "
CREATE TABLE {$_TABLES['pollanswers']} (
  pid varchar(20) NOT NULL default '',
  qid mediumint(9) NOT NULL default 0,
  aid tinyint(3) unsigned NOT NULL default '0',
  answer varchar(255) default NULL,
  votes mediumint(8) unsigned default NULL,
  remark varchar(255) NULL,
  PRIMARY KEY (pid, qid, aid)
) TYPE=MyISAM
";

$_SQL[] = "
CREATE TABLE {$_TABLES['pollquestions']} (
    qid mediumint(9) NOT NULL DEFAULT '0',
    pid varchar(20) NOT NULL,
    question varchar(255) NOT NULL,
    PRIMARY KEY (qid, pid)
) TYPE=MyISAM
";

$_SQL[] = "
CREATE TABLE {$_TABLES['polltopics']} (
  pid varchar(20) NOT NULL,
  topic varchar(255) default NULL,
  voters mediumint(8) unsigned default NULL,
  questions int(11) NOT NULL default '0',
  date datetime default NULL,
  display tinyint(4) NOT NULL default '0',
  open tinyint(4) NOT NULL default '1',
  hideresults tinyint(1) NOT NULL default '1',
  commentcode tinyint(4) NOT NULL default '0',
  statuscode tinyint(4) NOT NULL default '0',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  group_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '2',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  INDEX pollquestions_qid(pid),
  INDEX pollquestions_date(date),
  INDEX pollquestions_display(display),
  INDEX pollquestions_commentcode(commentcode),
  INDEX pollquestions_statuscode(statuscode),
  PRIMARY KEY  (pid)
) TYPE=MyISAM
";

$_SQL[] = "
CREATE TABLE {$_TABLES['pollvoters']} (
  id int(10) unsigned NOT NULL auto_increment,
  pid varchar(20) NOT NULL default '',
  ipaddress varchar(15) NOT NULL default '',
  date int(10) unsigned default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM
";

// Note: The 'pollquestion' entry for the above answers is in the install script

$_SQL[] = "INSERT INTO {$_TABLES['blocks']} (is_enabled, name, type, title, tid, blockorder, content, onleft, phpblockfn, owner_id, group_id, perm_owner, perm_group) VALUES (1,'polls_block','phpblock','Poll','all',30,'',0,'phpblock_polls',{$_USER['uid']},#group#,3,3)";

$_SQL[] = "INSERT INTO `{$_TABLES['pollanswers']}` (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES ('geeklogfeaturepoll', 0, 1, 'MS SQL support', 0, '');";
$_SQL[] = "INSERT INTO `{$_TABLES['pollanswers']}` (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES ('geeklogfeaturepoll', 0, 2, 'Multi-language support', 0, '');";
$_SQL[] = "INSERT INTO `{$_TABLES['pollanswers']}` (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES ('geeklogfeaturepoll', 0, 3, 'Calendar as a plugin', 0, '');";
$_SQL[] = "INSERT INTO `{$_TABLES['pollanswers']}` (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES ('geeklogfeaturepoll', 0, 4, 'SLV spam protection', 0, '');";
$_SQL[] = "INSERT INTO `{$_TABLES['pollanswers']}` (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES ('geeklogfeaturepoll', 0, 5, 'Mass-delete users', 0, '');";
$_SQL[] = "INSERT INTO `{$_TABLES['pollanswers']}` (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES ('geeklogfeaturepoll', 0, 6, 'Other', 0, '');";
$_SQL[] = "INSERT INTO `{$_TABLES['pollanswers']}` (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES ('geeklogfeaturepoll', 1, 1, 'Story-Images', 0, '');";
$_SQL[] = "INSERT INTO `{$_TABLES['pollanswers']}` (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES ('geeklogfeaturepoll', 1, 2, 'User-Rights handling', 0, '');";
$_SQL[] = "INSERT INTO `{$_TABLES['pollanswers']}` (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES ('geeklogfeaturepoll', 1, 3, 'The Support', 0, '');";
$_SQL[] = "INSERT INTO `{$_TABLES['pollanswers']}` (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES ('geeklogfeaturepoll', 1, 4, 'Plugin Availability', 0, '');";

$_SQL[] = "INSERT INTO `{$_TABLES['pollquestions']}` (`qid`, `pid`, `question`) VALUES (0, 'geeklogfeaturepoll', 'What is the best new feature of Geeklog?');";
$_SQL[] = "INSERT INTO `{$_TABLES['pollquestions']}` (`qid`, `pid`, `question`) VALUES (1, 'geeklogfeaturepoll', 'What is the all-time best feature of Geeklog?');";

?>
