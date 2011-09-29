<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Calendar Plugin 1.1                                                       |
// +---------------------------------------------------------------------------+
// | psgql_install.php                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs         - tony AT tonybibbs DOT com                   |
// |          Mark Limburg       - mlimburg AT users DOT sourceforge DOT net   |
// |          Jason Whittenburg  - jwhitten AT securitygeeks DOT com           |
// |          Dirk Haun          - dirk AT haun-online DOT de                  |
// |          Trinity Bays       - trinity93 AT gmail DOT com                  |
// |          Stanislav Palatnik - spalatnikk AT gmail DOT com                 |
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

$_SQL[] = "
CREATE TABLE {$_TABLES['events']} (
  eid varchar(20) NOT NULL default '',
  title varchar(128) default NULL,
  description text,
  postmode varchar(10) NOT NULL default 'plaintext',
  datestart date default NULL,
  dateend date default NULL,
  url varchar(255) default NULL,
  hits int  NOT NULL default '0',
  owner_id int NOT NULL default '1',
  group_id int NOT NULL default '1',
  perm_owner int NOT NULL default '3',
  perm_group int NOT NULL default '3',
  perm_members int NOT NULL default '2',
  perm_anon int NOT NULL default '2',
  address1 varchar(40) default NULL,
  address2 varchar(40) default NULL,
  city varchar(60) default NULL,
  state varchar(40) default NULL,
  zipcode varchar(5) default NULL,
  allday int NOT NULL default '0',
  event_type varchar(40) NOT NULL default '',
  location varchar(128) default NULL,
  timestart time default NULL,
  timeend time default NULL,
  PRIMARY KEY  (eid));
  CREATE INDEX {$_TABLES['events']}_eid ON {$_TABLES['events']}(eid);
  CREATE INDEX {$_TABLES['events']}_event_type ON {$_TABLES['events']}(event_type);
  CREATE INDEX {$_TABLES['events']}_datestart ON {$_TABLES['events']}(datestart);
  CREATE INDEX {$_TABLES['events']}_dateend ON {$_TABLES['events']}(dateend);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['eventsubmission']} (
  eid varchar(20) NOT NULL default '',
  title varchar(128) default NULL,
  description text,
  location varchar(128) default NULL,
  datestart date default NULL,
  dateend date default NULL,
  url varchar(255) default NULL,
  allday int NOT NULL default '0',
  zipcode varchar(5) default NULL,
  state varchar(40) default NULL,
  city varchar(60) default NULL,
  address2 varchar(40) default NULL,
  address1 varchar(40) default NULL,
  event_type varchar(40) NOT NULL default '',
  timestart time default NULL,
  timeend time default NULL,
  owner_id int NOT NULL default '1',
  PRIMARY KEY  (eid)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['personal_events']} (
  eid varchar(20) NOT NULL default '',
  title varchar(128) default NULL,
  event_type varchar(40) NOT NULL default '',
  datestart date default NULL,
  dateend date default NULL,
  address1 varchar(40) default NULL,
  address2 varchar(40) default NULL,
  city varchar(60) default NULL,
  state varchar(40) default NULL,
  zipcode varchar(5) default NULL,
  allday int NOT NULL default '0',
  url varchar(255) default NULL,
  description text,
  postmode varchar(10) NOT NULL default 'plaintext',
  owner_id int  NOT NULL default '1',
  group_id int NOT NULL default '1',
  perm_owner int NOT NULL default '3',
  perm_group int NOT NULL default '3',
  perm_members int NOT NULL default '2',
  perm_anon int  NOT NULL default '2',
  uid int NOT NULL default '0',
  location varchar(128) default NULL,
  timestart time default NULL,
  timeend time default NULL,
  PRIMARY KEY  (eid,uid)
)
";

$_SQL[] = "INSERT INTO {$_TABLES['eventsubmission']} (eid, title, description, location, datestart, dateend, url, allday, zipcode, state, city, address2, address1, event_type, timestart, timeend) VALUES ('2008050110130162','Installed the Calendar plugin','Today, you successfully installed the Calendar plugin.','Your webserver',CURDATE(),CURDATE(),'http://www.geeklog.net/',1,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL)";

?>
