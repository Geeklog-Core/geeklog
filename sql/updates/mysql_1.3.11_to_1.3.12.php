<?php

$_SQL[] = "CREATE TABLE {$_TABLES['trackback']} (
  cid int(10) unsigned NOT NULL auto_increment, 
  sid varchar(40) NOT NULL, 
  url varchar(255) default NULL,
  title varchar(128) default NULL,
  blog varchar(80) default NULL, 
  excerpt text,
  date datetime default NULL,
  type varchar(30) NOT NULL default 'article',
  ipaddress varchar(15) NOT NULL default '',
  PRIMARY KEY (cid),
  INDEX trackback_sid(sid), 
  INDEX trackback_url(url), 
  INDEX trackback_date(date), 
  INDEX trackback_type(type)
) TYPE=MyISAM";

$_SQL[] = "CREATE TABLE {$_TABLES['pingservice']} (
  pid smallint(5) unsigned NOT NULL auto_increment,
  name varchar(128) default NULL,
  ping_url varchar(255) default NULL,
  site_url varchar(255) default NULL,
  method varchar(80) default NULL,
  is_enabled tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (pid),
  INDEX pingservice_is_enabled(is_enabled)
) TYPE=MyISAM";

// some weblog directories to ping ...
$_SQL[] = "INSERT INTO {$_TABLES['pingservice']} (pid, name, site_url, ping_url, method, is_enabled) VALUES (1, 'blo.gs', 'http://blo.gs/', 'http://ping.blo.gs/', 'weblogUpdates.extendedPing', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['pingservice']} (pid, name, site_url, ping_url, method, is_enabled) VALUES (2, 'Weblogs.Com', 'http://www.weblogs.com/', 'http://rpc.weblogs.com/RPC2', 'weblogUpdates.ping', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['pingservice']} (pid, name, site_url, ping_url, method, is_enabled) VALUES (3, 'Blogrolling.com', 'http://fresh.blogrolling.com/', 'http://rpc.blogrolling.com/pinger/', 'weblogUpdates.ping', 1)";

// max. number of entries to import into a portal block
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD rdflimit smallint(5) unsigned NOT NULL default '0' AFTER rdfupdated";

// new story.ping feature (also see function upgrade_addFeature below)
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('story.ping', 'Ability to send pings, pingbacks, or trackbacks for stories', 1)";

// remote authentication fields
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD remoteusername varchar(60) NULL after username";
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD remoteservice varchar(60) NULL after remoteusername";
// new user status, for ban etc.
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD status smallint(5) unsigned NOT NULL default '1'";
// Make all users WITH a password active.
$_SQL[] = "UPDATE {$_TABLES['users']} SET status=3 WHERE (passwd IS NOT NULL) OR (passwd != '')";
// a few more indexes on the users table can' hurt ...
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD INDEX users_username(username)";
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD INDEX users_fullname(fullname)";
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD INDEX users_email(email)";
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD INDEX users_passwd(passwd)";
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD INDEX users_pwrequestid(pwrequestid)";
// Add the remote authenticated group:
$_SQL[] = "INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr, grp_gl_core) VALUES ('Remote Users', 'Users in this group can have authenticated against a remote server.',1) ";

// for dynamic comments
$_SQL[] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('dynamic', 'Dynamic')";

// for quicker access to large speedlimit tables
$_SQL[] = "ALTER TABLE {$_TABLES['speedlimit']} ADD INDEX type_ipaddress(type,ipaddress)";
$_SQL[] = "ALTER TABLE {$_TABLES['speedlimit']} ADD INDEX date(date)";

// new 'in transit' status
$_SQL[] = "ALTER TABLE {$_TABLES['stories']} ADD in_transit tinyint(1) unsigned default '0' AFTER frontpage";
$_SQL[] = "ALTER TABLE {$_TABLES['stories']} ADD INDEX stories_in_transit(in_transit)";

// new header-link for feeds
$_SQL[] = "ALTER TABLE {$_TABLES['syndication']} ADD header_tid varchar(48) NOT NULL default 'none' AFTER topic;";
// Upgrade format values
$_SQL[] = "UPDATE {$_TABLES['syndication']} SET `format`='RSS-0.91' WHERE format='rss'";
$_SQL[] = "UPDATE {$_TABLES['syndication']} SET `format`='RSS-2.0' WHERE format='rss2'";
$_SQL[] = "UPDATE {$_TABLES['syndication']} SET `format`='Atom-0.3' WHERE format='atom'";
$_SQL[] = "UPDATE {$_TABLES['syndication']} SET `format`='RDF-1.0' WHERE format='rdf'";

// add links plugin
$_SQL[] = "INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage) VALUES ('links', '1.0', '1.3.12', 1, 'http://www.geeklog.net/')";
// add polls plugin
$_SQL[] = "INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version,pi_enabled, pi_homepage) VALUES ('polls', '1.0', '1.3.12', '1', 'http://www.geeklog.net/')";

// updates core -> plugin
$_SQL[] = "UPDATE {$_TABLES['blocks']} SET `type`= 'phpblock', `phpblockfn`='phpblock_polls' WHERE `name`='poll_block';";

$_SQL[] = "UPDATE {$_TABLES['features']} SET ft_gl_core = '0', ft_name='polls.edit' WHERE ft_name = 'poll.edit';";
$_SQL[] = "UPDATE {$_TABLES['groups']} SET grp_gl_core = '0' WHERE grp_name = 'Link Admin';";
$_SQL[] = "UPDATE {$_TABLES['groups']} SET grp_gl_core = '0' WHERE grp_name = 'Poll Admin';";

// rename "link.*" features to "links.*" to match the plugin name
$_SQL[] = "UPDATE {$_TABLES['features']} SET ft_name = 'links.moderate', ft_gl_core = '0' WHERE ft_name = 'link.moderate';";
$_SQL[] = "UPDATE {$_TABLES['features']} SET ft_name = 'links.edit', ft_gl_core = '0' WHERE ft_name = 'link.edit';";
$_SQL[] = "UPDATE {$_TABLES['features']} SET ft_name = 'links.submit', ft_gl_core = '0' WHERE ft_name = 'link.submit';";

// add the new 'story.ping' feature to the Story Admin group
function upgrade_addFeature ()
{
    global $_TABLES;

    $grp_id = DB_getItem ($_TABLES['groups'], 'grp_id',
                          "grp_name = 'Story Admin'");
    $ft_id = DB_getItem ($_TABLES['features'], 'ft_id',
                         "ft_name = 'story.ping'");

    if (($grp_id > 0) && ($ft_id > 0)) {
        DB_query ("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($ft_id,$grp_id)");
    }
}

?>
