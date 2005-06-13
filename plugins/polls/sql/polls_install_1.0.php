<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +-----------------------------------------------------------------------------+
// | glRegistration Plugin 1.0 for Geeklog- The Ultimate OSS Portal              |
// | Date: March 23, 2003                                                        |
// +-----------------------------------------------------------------------------+
// | Installation SQL                                                            |
// +-----------------------------------------------------------------------------+
// | Copyright (C) 2003 by the following authors:                                |
// |                                                                             |
// | glRegistration Plugin Author:                                               |
// | Blaine Lang   -  blaine@portalparts.com                                     |
// +-----------------------------------------------------------------------------+
// | Geeklog Common Code                                                         |
// | Copyright (C) 2000-2003 by the following authors:                           |
// |                                                                             |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                             |
// |          Mark Limburg      - mlimburg@users.sourceforge.net                 |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                     |
// |          Dirk Haun         - dirk@haun-online.de                            |
// +-----------------------------------------------------------------------------+
// |                                                                             |
// | This program is licensed under the terms of the GNU General Public License  |
// | as published by the Free Software Foundation; either version 2              |
// | of the License, or (at your option) any later version.                      |
// |                                                                             |
// | This program is OpenSource but not FREE. Unauthorized distribution is       |
// | illegal. Anyone caught doing so will be banished from the geeklog community |
// | You may not remove the copyright or redistribute this script in any form.   |
// |                                                                             |
// | This program is distributed in the hope that it will be useful,             |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of              |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                        |
// | See the GNU General Public License for more details.                        |
// |                                                                             |
// | You should have received a copy of the GNU General Public License           |
// | along with this program; if not, write to the Free Software Foundation,     |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.             |
// |                                                                             |
// +-----------------------------------------------------------------------------+
//

//$_TABLES['pollanswers']         = $_DB_table_prefix . 'pollanswers_old';
//$_TABLES['pollquestions']       = $_DB_table_prefix . 'pollquestions_old';
//$_TABLES['pollvoters']          = $_DB_table_prefix . 'pollvoters_old';
# --------------------------------------------------------
$_SQL[1] = "
CREATE TABLE {$_TABLES['pollanswers']} (
  qid varchar(20) NOT NULL default '',
  aid tinyint(3) unsigned NOT NULL default '0',
  answer varchar(255) default NULL,
  votes mediumint(8) unsigned default NULL,
  PRIMARY KEY  (qid,aid)
) TYPE=MyISAM
";

$_SQL[2] = "
CREATE TABLE {$_TABLES['pollquestions']} (
  qid varchar(20) NOT NULL default '',
  question varchar(255) default NULL,
  voters mediumint(8) unsigned default NULL,
  date datetime default NULL,
  display tinyint(4) NOT NULL default '0',
  commentcode tinyint(4) NOT NULL default '0',
  statuscode tinyint(4) NOT NULL default '0',
  group_id mediumint(8) unsigned NOT NULL default '1',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '3',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  INDEX pollquestions_qid(qid),
  INDEX pollquestions_display(display),
  INDEX pollquestions_commentcode(commentcode),
  INDEX pollquestions_statuscode(statuscode),
  PRIMARY KEY  (qid)
) TYPE=MyISAM
";

$_SQL[3] = "
CREATE TABLE {$_TABLES['pollvoters']} (
  id int(10) unsigned NOT NULL auto_increment,
  qid varchar(20) NOT NULL default '',
  ipaddress varchar(15) NOT NULL default '',
  date int(10) unsigned default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM
";

$_SQL[4] = "INSERT INTO {$_TABLES['plugins']} (
    pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage
)
VALUES (
    'polls', '" . $_PO_CONF['version'] . "', '1.3.12', '1', 'http://www.geeklog.net/'
)
";

$_SQL[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',1,'Professional theme',0) ";
$_SQL[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',2,'SpamX plugin included',0) ";
$_SQL[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',3,'Story Archive feature',0) ";
$_SQL[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',4,'Clickable links in text mode',0) ";
$_SQL[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',5,'Autolinks / Autotags',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',6,'Other',0) ";

$_SQL[] = "INSERT INTO {$_TABLES['pollquestions']} (qid, question, voters, date, display, commentcode, statuscode, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('geeklogfeaturepoll','What is the best new feature of Geeklog?',0,'2004-01-01 12:43:20',1,0,0,8,2,3,3,2,2) ";

$_SQL[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('',1,'poll_block','phpblock','Poll','all',2,'','','0000-00-00 00:00:00',0,'phpblock_polls',1,2,3,3,2,2) ";

$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ('','poll.edit','Access to poll editor',0) ";

$_SQL[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ('','Poll Admin','Has full access to poll features',0) ";

?>
