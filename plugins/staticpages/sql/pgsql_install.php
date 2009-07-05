<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Plugin 1.4.2                                                 |
// +---------------------------------------------------------------------------+
// | Installation SQL                                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
// |          Tom Willett      - twillett AT users DOT sourceforge DOT net     |
// |          Blaine Lang      - langmail AT sympatico DOT ca                  |
// |          Dirk Haun        - dirk AT haun-online DOT de                    |
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
// $Id: mysql_install.php,v 1.3 2007/08/09 18:29:34 dhaun Exp $

$_SQL[] = "
CREATE TABLE {$_TABLES['staticpage']} (
  sp_id varchar(40) NOT NULL default '',
  sp_uid int NOT NULL default '1',
  sp_title varchar(128) NOT NULL default '',
  sp_content text NOT NULL,
  sp_hits int NOT NULL default '0',
  sp_date timestamp NOT NULL default NULL,
  sp_format varchar(20) NOT NULL default '',
  sp_onmenu int NOT NULL default '0',
  sp_label varchar(64) default NULL,
  commentcode int NOT NULL default '0',
  owner_id int NOT NULL default '1',
  group_id int NOT NULL default '1',
  perm_owner int NOT NULL default '3',
  perm_group int NOT NULL default '2',
  perm_members int NOT NULL default '2',
  perm_anon int NOT NULL default '2',
  sp_centerblock int NOT NULL default '0',
  sp_help varchar(255) default '',
  sp_tid varchar(20) NOT NULL default 'none',
  sp_where int NOT NULL default '1',
  sp_php int NOT NULL default '0',
  sp_nf int default '0',
  sp_inblock int default '1',
  postmode varchar(16) NOT NULL default 'html',
  PRIMARY KEY  (sp_id));
  CREATE INDEX staticpage_sp_uid ON {$_TABLES['staticpage']}(sp_uid);
  CREATE INDEX staticpage_sp_date ON {$_TABLES['staticpage']}(sp_date);
  CREATE INDEX staticpage_sp_onmenu ON {$_TABLES['staticpage']}(sp_onmenu);
  CREATE INDEX staticpage_sp_centerblock ON {$_TABLES['staticpage']}(sp_centerblock);
  CREATE INDEX staticpage_sp_tid ON {$_TABLES['staticpage']}(sp_tid);
  CREATE INDEX staticpage_sp_where ON {$_TABLES['staticpage']}(sp_where);
";

?>
