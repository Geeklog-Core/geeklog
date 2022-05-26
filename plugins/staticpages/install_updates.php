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

    // Allow template static pages not to be included in search
    $c->add('includesearchtemplate',$_SP_DEFAULT['include_search_template'],'select',
            0, 2, 0, 40, TRUE, 'staticpages', 2);

    return true;
}

function staticpages_update_search_cache_1_7_1()
{
    global $_TABLES;

    // Only update if not done before
    // Move content for php and template pages (and templates themselves) to page_data column
    $sql = "UPDATE {$_TABLES['staticpage']}
        SET page_data = sp_content, sp_content = ''
        WHERE page_data IS NULL AND draft_flag = 0 AND (template_id !='' OR template_flag = 1 OR sp_php > 0)";
    $result = DB_query($sql);

    // Now find the php pages and template pages and update search cache
    // Code commented out as it can cause runtime errors if the template page or php page requires something that is not accessible by the Geeklog Installer
    // Therefore before these pages search cache can be created and searched: Pages that are not cached must be saved again, Pages that use the cache must be visited or saved again.
    /*
    $sql = "SELECT * FROM {$_TABLES['staticpage']}
        WHERE sp_content = '' AND draft_flag = 0 AND (template_id !='' OR sp_php > 0)";
    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);

        if ($A['sp_php'] > 0) {
            if ($A['sp_php'] == 1) {
                $search_sp_content = eval($A['page_data']);
            } elseif ($A['sp_php'] == 2) {
                ob_start();
                eval($A['page_data']);
                $search_sp_content = ob_get_contents();
                ob_end_clean();
            }
        } else {
            $search_sp_content = SP_returnStaticpage($A['sp_id'], 'autotag');
        }

        $search_sp_content = DB_escapeString($search_sp_content);
        $sqlB = "UPDATE {$_TABLES['staticpage']} SET sp_content = '$search_sp_content' WHERE sp_id = '{$A['sp_id']}'";
        $resultB = DB_query($sqlB);
    }
    */


    return true;
}

function staticpages_addStructuredDataSecurityRight_1_7_1()
{
    global $_TABLES;

    // Give "structureddata.autotag" feature to Static Page Admin
    if (DB_count($_TABLES['features'], 'ft_name', 'structureddata.autotag') == 1) {
        $featureId = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = 'structureddata.autotag' ");
        $staticPageAdminId = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Static Page Admin' ");
        DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ({$featureId}, {$staticPageAdminId}) ");
    }
}

function staticpages_update_ConfValues_1_7_2()
{
    global $_CONF, $_TABLES, $_SP_DEFAULT;

    $c = config::get_instance();

    require_once $_CONF['path'] . 'plugins/staticpages/install_defaults.php';

    // Parse any PHP for errors included in page, on save of page
    $c->add('enable_eval_php_save', $_SP_DEFAULT['enable_eval_php_save'], 'select', 0, 0, 0, 15, true, 'staticpages', 0);

    return true;
}

function staticpages_update_ConfValues_1_7_3()
{
    global $_CONF, $_TABLES, $_SP_DEFAULT;

    $c = config::get_instance();

    require_once $_CONF['path'] . 'plugins/staticpages/install_defaults.php';

    // Likes
	$c->add('likes_pages', $_SP_DEFAULT['likes_pages'], 'select',
			0, 0, 41, 130, true, 'staticpages', 0);		

    return true;
}