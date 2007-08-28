<?php

// SQL for updating the links plugin from version 1.0 and 1.0.1 to 2
//

$LINKS_SQL['linkcategories'] = "
CREATE TABLE {$_TABLES['linkcategories']} (
  cid varchar(20) NOT NULL,
  pid varchar(20) NOT NULL,
  category varchar(32) NOT NULL,
  description text DEFAULT NULL,
  tid varchar(20) DEFAULT NULL,
  created datetime DEFAULT NULL,
  modified datetime DEFAULT NULL,
  owner_id mediumint(8) unsigned NOT NULL default '1',
  group_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '2',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  PRIMARY KEY (cid),
  KEY links_pid (pid)
) TYPE=MyISAM
";

$LINKS_SQL['getcategories'] = "SELECT DISTINCT category FROM {$_TABLES['links']}";

// add owner-field to links-submission
$LINKS_SQL['linksubmission1'] = "ALTER TABLE {$_TABLES['linksubmission']} ADD owner_id mediumint(8) unsigned NOT NULL default '1';";
$LINKS_SQL['linksubmission2'] = "ALTER TABLE {$_TABLES['linksubmission']} CHANGE category cid varchar(20) NOT NULL";

$LINKS_SQL['links'] = "ALTER TABLE {$_TABLES['links']} CHANGE category cid varchar(20) NOT NULL";

$LINKS_SQL['root'] = "INSERT INTO {$_TABLES['linkcategories']} (cid, pid, category, description, tid, created, modified, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('site', 'root', 'Root', 'Website root', '', NOW(), NOW(), 5, 2, 3, 3, 2, 2)";

$LINKS_SQL['linksblock'] = "INSERT INTO {$_TABLES['blocks']} (is_enabled, name, type, title, tid, blockorder, content, allow_autotags, rdfurl, rdfupdated, rdflimit, onleft, phpblockfn, help, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (1, 'links_topic_links', 'phpblock', 'Topic Links', 'all', 0, '', 0, '', '0000-00-00 00:00:00', 0, 0, 'phpblock_topic_links', '', 2, {$blockadmin_id}, 3, 3, 2, 2)";

$LINKS_SQL['categoriesblock'] = "INSERT INTO {$_TABLES['blocks']} (is_enabled, name, type, title, tid, blockorder, content, allow_autotags, rdfurl, rdfupdated, rdflimit, onleft, phpblockfn, help, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (1, 'links_topic_categories', 'phpblock', 'Topic Categories', 'all', 0, '', 0, '', '0000-00-00 00:00:00', 0, 0, 'phpblock_topic_categories', '', 2, {$blockadmin_id}, 3, 3, 2, 2)";


?>
