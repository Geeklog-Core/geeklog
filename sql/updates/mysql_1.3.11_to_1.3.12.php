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

// a few more indexes on the users table can' hurt ...
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD INDEX users_username(username)";
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD INDEX users_fullname(fullname)";
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD INDEX users_email(email)";
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD INDEX users_passwd(passwd)";
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD INDEX users_pwrequestid(pwrequestid)";

// for dynamic comments
$_SQL[] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('dynamic', 'Dynamic')";

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
