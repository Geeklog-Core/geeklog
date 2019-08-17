<?php

function SP_update_ConfValues_1_6_3()
{
    global $_CONF, $_TABLES, $_SP_DEFAULT;

    $c = config::get_instance();

    require_once $_CONF['path'] . 'plugins/staticpages/install_defaults.php';

    // Autotag usage permissions
    $c->add('fs_autotag_permissions', NULL, 'fieldset',
            0, 10, NULL, 0, true, 'staticpages', 10);
    $c->add('autotag_permissions_staticpage', $_SP_DEFAULT['autotag_permissions_staticpage'], '@select',
            0, 10, 13, 10, true, 'staticpages', 10);
    $c->add('autotag_permissions_staticpage_content', $_SP_DEFAULT['autotag_permissions_staticpage_content'], '@select',
            0, 10, 13, 10, true, 'staticpages', 10);

    // Add in all the New Tabs
    $c->add('tab_main', NULL, 'tab', 0, 0, NULL, 0, true, 'staticpages', 0);
    $c->add('tab_whatsnew', NULL, 'tab', 0, 1, NULL, 0, true, 'staticpages', 1);
    $c->add('tab_search', NULL, 'tab', 0, 2, NULL, 0, true, 'staticpages', 2);
    $c->add('tab_permissions', NULL, 'tab', 0, 3, NULL, 0, true, 'staticpages', 3);
    $c->add('tab_autotag_permissions', NULL, 'tab', 0, 10, NULL, 0, true, 'staticpages', 10);

    return true;
}

function SP_update_TopicAssignmentsFor_1_6_4()
{
    global $_TABLES;

    $sql = "SELECT * FROM {$_TABLES['staticpage']}";
    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);

        if ($A['sp_tid'] == 'all') {
            $A['sp_tid'] = TOPIC_ALL_OPTION;
        } elseif ($A['sp_tid'] == 'none' AND $A['sp_centerblock'] == 1) { // If center block enabled and none then homepage
            $A['sp_tid'] = TOPIC_HOMEONLY_OPTION;
        } elseif ($A['sp_tid'] == 'none' AND $A['sp_centerblock'] == 0) { // If center block disabled and none then all
            $A['sp_tid'] = TOPIC_ALL_OPTION;
        }

        $sql = "INSERT INTO {$_TABLES['topic_assignments']} (tid, type, id, inherit, tdefault) VALUES ('{$A['sp_tid']}', 'staticpages', '{$A['sp_id']}', 1, 1)";
        DB_query($sql);
    }

    // Remove Topic Id from blocks table
    $sql = "ALTER TABLE {$_TABLES['staticpage']} DROP `sp_tid`";
    DB_query($sql);
}

function SP_update_ConfValues_1_6_4()
{
    global $_CONF, $_TABLES, $_SP_DEFAULT;

    $c = config::get_instance();

    require_once $_CONF['path'] . 'plugins/staticpages/install_defaults.php';

    // Breadcrumbs
    $c->add('disable_breadcrumbs_staticpages', $_SP_DEFAULT['disable_breadcrumbs_staticpages'], 'select',
            0, 0, 0, 128, true, 'staticpages', 0);

    return true;
}

function SP_update_ConfValues_1_6_5()
{
    global $_CONF, $_TABLES, $_SP_DEFAULT;

    $c = config::get_instance();

    require_once $_CONF['path'] . 'plugins/staticpages/install_defaults.php';

    // Cache Time
    $c->add('default_cache_time', $_SP_DEFAULT['default_cache_time'], 'text',
            0, 0, null, 129, true, 'staticpages', 0);

    return true;
}

function SP_update_ConfValues_1_7_0()
{
    global $_CONF, $_TABLES, $_SP_DEFAULT;

    $c = config::get_instance();

    require_once $_CONF['path'] . 'plugins/staticpages/install_defaults.php';

    // Hidden config option for Core used to determine language of staticpage url (see _getLanguageInfoFromURL in lib-common)
    $c->add('langurl_staticpages',array('staticpages', 'index.php', 'page'),'@hidden',7,31,1,1830,TRUE, 'Core', 31); 

    return true;
}

function staticpages_update_ConfValues_1_7_1()
{
    global $_CONF, $_TABLES, $_SP_DEFAULT;

    $c = config::get_instance();

    require_once $_CONF['path'] . 'plugins/staticpages/install_defaults.php';

    // Default Structured Data type for new pages
    $c->add('structured_data_type_default', $_SP_DEFAULT['structured_data_type_default'], 'select', 0, 0, 39, 126, true, 'staticpages', 0);
    
    // Deleted somewhat duplicate config value that was added on new installs of Staticpages 1.7.0 (not on upgrades)
    // The actual config value is hidden and used in support of multi language pages (see _getLanguageInfoFromURL in lib-common)
    $c->del('langurl_staticpages', 'staticpages');

    return true;
}
