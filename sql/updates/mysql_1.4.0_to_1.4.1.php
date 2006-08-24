<?php

// new 'syndication.edit' feature
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('syndication.edit', 'Access to Content Syndication', 1)";

// add the 'Syndication Admin' group
$_SQL[] = "INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr, grp_gl_core) VALUES ('Syndication Admin', 'Can create and modify web feeds for the site',1) ";

// add remarks-field to polls
$_SQL[] = "ALTER TABLE {$_TABLES['pollanswers']} ADD remark varchar(255) NULL AFTER votes";

// add field to support advanced editor in staticpages
$_SQL[] = "ALTER TABLE {$_TABLES['staticpage']} ADD postmode varchar(16) DEFAULT 'html' NOT NULL AFTER sp_inblock";
$_SQL[] = "ALTER TABLE {$_TABLES['staticpage']} ADD sp_help varchar(255) default '' AFTER sp_centerblock";

// update plugin version numbers
$_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version = '1.0.1', pi_gl_version = '1.4.1' WHERE pi_name = 'links'";
$_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version = '1.1.0', pi_gl_version = '1.4.1' WHERE pi_name = 'polls'";
$_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version = '1.1.0', pi_gl_version = '1.4.1' WHERE pi_name = 'spamx'";
$_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version = '1.4.3', pi_gl_version = '1.4.1' WHERE pi_name = 'staticpages'";

// Calendar plugin
$_SQL[] = "INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage) VALUES ('calendar', '1.0.0', '1.4.1', 1, 'http://www.geeklog.net/')";
$_SQL[] = "UPDATE {$_TABLES['features']} SET ft_name = 'calendar.edit', ft_gl_core = '0' WHERE ft_name = 'event.edit'";
$_SQL[] = "UPDATE {$_TABLES['features']} SET ft_name = 'calendar.moderate', ft_gl_core = '0' WHERE ft_name = 'event.moderate'";
$_SQL[] = "UPDATE {$_TABLES['features']} SET ft_name = 'calendar.submit', ft_gl_core = '0' WHERE ft_name = 'event.submit'";
$_SQL[] = "UPDATE {$_TABLES['groups']} SET grp_name = 'Calendar Admin', grp_gl_core = '0' WHERE grp_name = 'Event Admin'";
$_SQL[] = "UPDATE {$_TABLES['blocks']} SET type = 'phpblock', phpblockfn ='phpblock_calendar' WHERE name = 'events_block'";

// add new field to the stories table to indicate story was created or last updated using the advanced editor
$_SQL[] = "ALTER TABLE {$_TABLES['stories']} ADD advanced_editor_mode tinyint(1) unsigned default '0' AFTER postmode";

// add new field to enable/disable use of autotags in "normal" blocks
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD allow_autotags tinyint(1) unsigned NOT NULL DEFAULT '0' AFTER content";

// allow up to 255 characters for the help URL
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} CHANGE help help varchar(255) default ''";

// add the new 'syndication.edit' feature and the 'Syndication Admin' group
function upgrade_addSyndicationFeature ()
{
    global $_TABLES;

    $ft_id = DB_getItem ($_TABLES['features'], 'ft_id',
                         "ft_name = 'syndication.edit'");
    $grp_id = DB_getItem ($_TABLES['groups'], 'grp_id',
                          "grp_name = 'Syndication Admin'");
    $rootgrp = DB_getItem ($_TABLES['groups'], 'grp_id',
                           "grp_name = 'Root'");

    if(($grp_id > 0) && ($ft_id > 0)) {
        // add 'syndication.edit' feature to 'Syndication Admin' group
        DB_query ("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($ft_id, $grp_id)");

        // make 'Root' members a member of 'Syndication Admin'
        if($rootgrp > 0) {
            DB_query ("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES ($grp_id, NULL, $rootgrp)");
        }
    }
}

// The 'last_scheduled_run' entry was introduced in Geeklog 1.4.0 but was
// missing from the upgrade, i.e. it exists only on fresh 1.4.0 installs.
function upgrade_ensureLastScheduledRunFlag ()
{
    global $_TABLES;

    $val = DB_getItem ($_TABLES['vars'], 'value',
                       "name = 'last_scheduled_run'");
    if (empty ($val)) {
        DB_save ($_TABLES['vars'], 'name,value', "'last_scheduled_run',''");
    }
}

?>
