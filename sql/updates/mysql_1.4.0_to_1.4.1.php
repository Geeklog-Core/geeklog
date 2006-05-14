<?php

// new 'syndication.edit' feature
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('syndication.edit', 'Access to Content Syndication', 1)";

// add the 'Syndication Admin' group
$_SQL[] = "INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr, grp_gl_core) VALUES ('Syndication Admin', 'Can create and modify web feeds for the site',1) ";

// add remarks-field to polls
$_SQL[] = "ALTER TABLE {$_TABLES['pollanswers']} ADD remark varchar(255) NULL AFTER votes";

// update plugin version numbers
$_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version = '1.0.1', pi_gl_version = '1.4.1' WHERE pi_name = 'links'";
$_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version = '1.1' WHERE pi_name = 'polls'";
$_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version = '1.0.4' WHERE pi_name = 'spamx'";
$_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version = '1.4.3' WHERE pi_name = 'staticpages'";

// Calendar plugin
$_SQL[] = "INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage) VALUES ('calendar', '1.0', '1.4.1', 1, 'http://www.geeklog.net/')";
$_SQL[] = "UPDATE {$_TABLES['features']} SET ft_gl_core = '0' WHERE ft_name = 'event.edit'";
$_SQL[] = "UPDATE {$_TABLES['features']} SET ft_gl_core = '0' WHERE ft_name = 'event.moderate'";
$_SQL[] = "UPDATE {$_TABLES['features']} SET ft_gl_core = '0' WHERE ft_name = 'event.submit'";
$_SQL[] = "UPDATE {$_TABLES['groups']} SET grp_gl_core = '0' WHERE grp_name = 'Event Admin'";

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

?>
