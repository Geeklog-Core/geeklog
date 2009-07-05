<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Links Plugin 2.0                                                          |
// +---------------------------------------------------------------------------+
// | Installation SQL                                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2008 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Trinity Bays      - trinity93 AT gmail DOT com               |
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
 * Links plugin Installation SQL
 *
 * @package Links
 * @filesource
 * @version 2.0
 * @since GL 1.4.0
 * @copyright Copyright &copy; 2005-2008
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Trinity Bays <trinity93@gmail.com>
 * @author Tony Bibbs <tony@tonybibbs.com>
 * @author Tom Willett <twillett@users.sourceforge.net>
 * @author Blaine Lang <langmail@sympatico.ca>
 * @author Dirk Haun <dirk@haun-online.de>
 *
 */


$_SQL[] = "
CREATE TABLE {$_TABLES['linkcategories']} (
  cid varchar(32) NOT NULL,
  pid varchar(32) NOT NULL,
  category varchar(32) NOT NULL,
  description text DEFAULT NULL,
  tid varchar(20) DEFAULT NULL,
  created timestamp DEFAULT NULL,
  modified timestamp DEFAULT NULL,
  owner_id int NOT NULL default '1',
  group_id int NOT NULL default '1',
  perm_owner int NOT NULL default '3',
  perm_group int NOT NULL default '2',
  perm_members int NOT NULL default '2',
  perm_anon int NOT NULL default '2',
  PRIMARY KEY (cid));
  CREATE INDEX links_pid ON {$_TABLES['linkcategories']}(pid);

";

$_SQL[] = "
CREATE TABLE {$_TABLES['links']} (
  lid varchar(40) NOT NULL default '',
  cid varchar(32) default NULL,
  url varchar(255) default NULL,
  description text,
  title varchar(96) default NULL,
  hits int NOT NULL default '0',
  date timestamp default NULL,
  owner_id int NOT NULL default '1',
  group_id int NOT NULL default '1',
  perm_owner int NOT NULL default '3',
  perm_group int NOT NULL default '2',
  perm_members int NOT NULL default '2',
  perm_anon int NOT NULL default '2',
  PRIMARY KEY (lid));
  CREATE INDEX links_category ON {$_TABLES['links']}(cid);
  CREATE INDEX links_date ON {$_TABLES['links']}(date);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['linksubmission']} (
  lid varchar(40) NOT NULL default '',
  cid varchar(32) default NULL,
  url varchar(255) default NULL,
  description text,
  title varchar(96) default NULL,
  hits int default NULL,
  date timestamp default NULL,
  owner_id int NOT NULL default '1',
  PRIMARY KEY (lid)
)
";

?>
