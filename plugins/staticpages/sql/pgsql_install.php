<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Plugin 1.6                                                   |
// +---------------------------------------------------------------------------+
// | Installation SQL                                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Stansislav Palatnik - spalatnikk AT gmail DOT com                |
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
* PostgreSQL install data and tables
*
* @package StaticPages
*/

$_SQL[] = "
CREATE TABLE {$_TABLES['staticpage']} (
  sp_id varchar(40) NOT NULL default '',
  sp_uid int NOT NULL default '1',
  sp_title varchar(128) NOT NULL default '',
  sp_page_title varchar(128) NOT NULL default '',
  sp_content text NOT NULL,
  sp_hits int NOT NULL default '0',
  created timestamp NOT NULL default NULL,
  modified timestamp NOT NULL default NULL,
  sp_format varchar(20) NOT NULL default '',
  sp_onmenu int NOT NULL default '0',
  sp_label varchar(64) default NULL,
  commentcode int NOT NULL default '0',
  meta_description TEXT NULL,
  meta_keywords TEXT NULL,
  template_flag int default '0',
  template_id varchar(40) NOT NULL default '',
  draft_flag int default '0',
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
  CREATE INDEX staticpage_created ON {$_TABLES['staticpage']}(created);
  CREATE INDEX staticpage_sp_onmenu ON {$_TABLES['staticpage']}(sp_onmenu);
  CREATE INDEX staticpage_sp_centerblock ON {$_TABLES['staticpage']}(sp_centerblock);
  CREATE INDEX staticpage_sp_tid ON {$_TABLES['staticpage']}(sp_tid);
  CREATE INDEX staticpage_sp_where ON {$_TABLES['staticpage']}(sp_where);
";

?>
