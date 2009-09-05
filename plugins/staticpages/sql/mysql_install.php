<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Plugin 1.6                                                   |
// +---------------------------------------------------------------------------+
// | Installation SQL                                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2009 by the following authors:                         |
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

/**
* MySQL install
*
* @package StaticPages
*/

$_SQL[] = "
CREATE TABLE {$_TABLES['staticpage']} (
  sp_id varchar(40) NOT NULL default '',
  sp_uid mediumint(8) NOT NULL default '1',
  sp_title varchar(128) NOT NULL default '',
  sp_content text NOT NULL,
  sp_hits mediumint(8) unsigned NOT NULL default '0',
  sp_date datetime NOT NULL default '0000-00-00 00:00:00',
  sp_format varchar(20) NOT NULL default '',
  sp_onmenu tinyint(1) unsigned NOT NULL default '0',
  sp_label varchar(64) default NULL,
  commentcode tinyint(4) NOT NULL default '0',
  meta_description TEXT NULL,
  meta_keywords TEXT NULL,  
  owner_id mediumint(8) unsigned NOT NULL default '1',
  group_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '2',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  sp_centerblock tinyint(1) unsigned NOT NULL default '0',
  sp_help varchar(255) default '',
  sp_tid varchar(20) NOT NULL default 'none',
  sp_where tinyint(1) unsigned NOT NULL default '1',
  sp_php tinyint(1) unsigned NOT NULL default '0',
  sp_nf tinyint(1) unsigned default '0',
  sp_inblock tinyint(1) unsigned default '1',
  postmode varchar(16) NOT NULL default 'html',
  PRIMARY KEY  (sp_id),
  KEY staticpage_sp_uid (sp_uid),
  KEY staticpage_sp_date (sp_date),
  KEY staticpage_sp_onmenu (sp_onmenu),
  KEY staticpage_sp_centerblock (sp_centerblock),
  KEY staticpage_sp_tid (sp_tid),
  KEY staticpage_sp_where (sp_where)
) TYPE=MyISAM
";

?>
