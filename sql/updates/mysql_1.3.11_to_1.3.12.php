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

$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD rdflimit smallint(5) unsigned NOT NULL default '0' AFTER rdfupdated";

$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('story.ping', 'Ability to send pings, pingbacks, or trackbacks for stories', 1)";

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
