<?php

// in_transit column is no longer used
$_SQL[] = "ALTER TABLE {$_TABLES['stories']} DROP INDEX stories_in_transit";
$_SQL[] = "ALTER TABLE {$_TABLES['stories']} DROP COLUMN in_transit";

// new plugin permissions
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('plugin.install','Can install/uninstall plugins',1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('plugin.upload','Can upload new plugins',1)";
$_SQL[] = "UPDATE {$_TABLES['features']} SET ft_descr = 'Can change plugin status' WHERE ft_name = 'plugin.edit'";

// new group.assign permission
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('group.assign','Ability to assign users to groups',1)";

// new comment tables, groups, and permissions
$_SQL[] = "
CREATE TABLE {$_TABLES['commentedits']} (
  cid int(10) NOT NULL,
  uid mediumint(8) NOT NULL,
  time datetime NOT NULL,
  PRIMARY KEY (cid)
) ENGINE=MyISAM
";
$_SQL[] = "
CREATE TABLE {$_TABLES['commentnotifications']} (
  cid int(10) default NULL,
  uid mediumint(8) NOT NULL,
  deletehash varchar(32) NOT NULL,
  mid int(10) default NULL,
  PRIMARY KEY  (deletehash)
) ENGINE=MyISAM 
";
$_SQL[] = "
CREATE TABLE {$_TABLES['commentsubmissions']} (
  cid int(10) unsigned NOT NULL auto_increment,
  type varchar(30) NOT NULL default 'article',
  sid varchar(40) NOT NULL,
  date datetime default NULL,
  title varchar(128) default NULL,
  comment text,
  uid mediumint(8) NOT NULL default '1',
  name varchar(32) default NULL,
  pid int(10) NOT NULL default '0',
  ipaddress varchar(15) NOT NULL,
  PRIMARY KEY  (cid)
) ENGINE=MyISAM
";
$_SQL[] = "ALTER TABLE {$_TABLES['stories']} ADD comment_expire datetime NOT NULL default '0000-00-00 00:00:00' AFTER comments";
$_SQL[] = "ALTER TABLE {$_TABLES['comments']} ADD name varchar(32) default NULL AFTER indent";
$_SQL[] = "INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr, grp_gl_core) VALUES ('Comment Admin', 'Can moderate comments', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr, grp_gl_core) VALUES ('Comment Submitters', 'Can submit comments', 0);";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('comment.moderate', 'Ability to moderate comments', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('comment.submit', 'Comments are automatically published', 1)";

// fix date format string
$_SQL[] = "UPDATE {$_TABLES['dateformats']} SET format = '%I:%M%p  %B %e, %Y', description = '10:00PM  March 21, 1999' WHERE dfid = 13";

/**
 * Add new config options
 *
 */
function update_ConfValues()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    // remove pdf_enabled option; this also makes room for new search options
    DB_delete($_TABLES['conf_values'], 'name', 'pdf_enabled');

    // move num_search_results options
    DB_query("UPDATE {$_TABLES['conf_values']} SET sort_order = 651 WHERE sort_order = 670");
    // change default for num_search_results
    $thirty = addslashes(serialize(30));
    DB_query("UPDATE {$_TABLES['conf_values']} SET value = '$thirty', default_value = '$thirty' WHERE name = 'num_search_results'");

    // fix censormode dropdown
    DB_query("UPDATE {$_TABLES['conf_values']} SET selectionArray = 18 WHERE name = 'censormode'");

    $c = config::get_instance();

    // new options
    $c->add('jpeg_quality',75,'text',5,23,NULL,1495,FALSE);
    $c->add('advanced_html',array ('img' => array('width' => 1, 'height' => 1, 'src' => 1, 'align' => 1, 'valign' => 1, 'border' => 1, 'alt' => 1)),'**placeholder',7,34,NULL,1721,TRUE);

    // squeeze search options between 640 (lastlogin) and 680 (loginrequired)
    $c->add('fs_search', NULL, 'fieldset', 0, 6, NULL, 0, TRUE);
    $c->add('search_style','google','select',0,6,19,644,TRUE);
    $c->add('search_limits','10,15,25,30','text',0,6,NULL,647,TRUE);
    // see above: $c->add('num_search_results',30,'text',0,6,NULL,651,TRUE);
    $c->add('search_show_limit',TRUE,'select',0,6,1,654,TRUE);
    $c->add('search_show_sort',TRUE,'select',0,6,1,658,TRUE);
    $c->add('search_show_num',TRUE,'select',0,6,1,661,TRUE);
    $c->add('search_show_type',TRUE,'select',0,6,1,665,TRUE);
    $c->add('search_separator',' &gt; ','text',0,6,NULL,668,TRUE);
    $c->add('search_def_keytype','phrase','select',0,6,20,672,TRUE);
    $c->add('search_use_fulltext',FALSE,'hidden',0,6); // 675

    // filename mask for db backup files
    $c->add('mysqldump_filename_mask','geeklog_db_backup_%Y_%m_%d_%H_%M_%S.sql','text',0,5,NULL,185,TRUE);

    // DOCTYPE declaration, for {doctype} in header.thtml
    $c->add('doctype','html401strict','select',2,10,21,195,TRUE);

    // new comment options
    $c->add('comment_edit',0,'select',4,21,0,1680,TRUE);
    $c->add('commentsubmission',0,'select',4,21,0, 1682, TRUE);
    $c->add('comment_edittime',1800,'text',4,21,NULL,1684,TRUE);
    $c->add('article_comment_close_days',30,'text',4,21,NULL,1686,TRUE);
    $c->add('comment_close_rec_stories',0,'text',4,21,NULL,1688,TRUE);
    $c->add('allow_reply_notifications',0,'select',4,21,0, 1689, TRUE);

    // cookie to store name of anonymous commenters
    $c->add('cookie_anon_name','anon_name','text',7,30,NULL,577,TRUE);

    // enable/disable clickable links
    $c->add('clickable_links',1,'select',7,31,1,1753,TRUE);

    // experimental: compress output before sending it to the browser
    $c->add('compressed_output',0,'select',7,31,1,1756,TRUE);

    // for the X-FRAME-OPTIONS header (Clickjacking protection)
    $c->add('frame_options','DENY','select',7,31,22,1758,TRUE);

    return true;
}

/**
 * Add new permissions
 *
 */
function upgrade_addNewPermissions()
{
    global $_TABLES;

    $install_id = DB_getItem($_TABLES['features'], 'ft_id',
                             "ft_name = 'plugin.install'");
    $upload_id = DB_getItem($_TABLES['features'], 'ft_id',
                            "ft_name = 'plugin.upload'");
    $plg_id = DB_getItem($_TABLES['groups'], 'grp_id',
                         "grp_name = 'Plugin Admin'");

    if (($plg_id > 0) && ($install_id > 0) && ($upload_id > 0)) {
        DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($install_id, $plg_id)");
        DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($upload_id, $plg_id)");
    }

    $assign_id = DB_getItem($_TABLES['features'], 'ft_id',
                            "ft_name = 'group.assign'");
    $grp_id = DB_getItem($_TABLES['groups'], 'grp_id',
                         "grp_name = 'Group Admin'");

    if (($grp_id > 0) && ($assign_id > 0)) {
        DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($assign_id, $grp_id)");
    }

    // comment groups and permissions
    $cmt_mod_id = DB_getItem($_TABLES['features'], 'ft_id',
                             "ft_name = 'comment.moderate'");
    $cmt_sub_id = DB_getItem($_TABLES['features'], 'ft_id',
                             "ft_name = 'comment.submit'");
    $cmt_admin = DB_getItem($_TABLES['groups'], 'grp_id',
                            "grp_name = 'Comment Admin'");
    $cmt_submitter = DB_getItem($_TABLES['groups'], 'grp_id',
                                "grp_name = 'Comment Submitters'");

    if (($cmt_mod_id > 0) && ($cmt_admin > 0)) {
        DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($cmt_mod_id, $cmt_admin)");
    }
    if (($cmt_sub_id > 0) && ($cmt_submitter > 0)) {
        DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($cmt_sub_id, $cmt_submitter)");
    }
    if ($cmt_admin > 0) {
        DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES ($cmt_admin,NULL,1)");
    }
    if ($cmt_submitter > 0) {
        DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES ($cmt_submitter,NULL,1)");
    }
}

/**
 * Add ISO 8601-ish date/time format
 *
 */
function upgrade_addIsoFormat()
{
    global $_TABLES;

    $maxid = DB_getItem($_TABLES['dateformats'], 'MAX(dfid)');
    $maxid++;
    DB_save($_TABLES['dateformats'], 'dfid,format,description',
            "$maxid,'%Y-%m-%d %H:%M','1999-03-21 22:00'");
}

?>
