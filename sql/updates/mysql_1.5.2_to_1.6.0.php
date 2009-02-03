<?php

// in_transit column is no longer used
$_SQL[] = "ALTER TABLE {$_TABLES['stories']} DROP INDEX stories_in_transit";
$_SQL[] = "ALTER TABLE {$_TABLES['stories']} DROP COLUMN in_transit";

// new plugin permissions
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('plugin.install','Can install/uninstall plugins',1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('plugin.upload','Can upload new plugins',1)";
$_SQL[] = "UPDATE {$_TABLES['features']} SET ft_descr = 'Can change plugin status' WHERE ft_name = 'plugin.edit'";

/**
 * Add new config options
 *
 */
function update_ConfValues()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    // move pdf_enabled option to make room for new search options
    DB_query("UPDATE {$_TABLES['conf_values']} SET sort_order = 795 WHERE sort_order = 660");
    // move num_search_results options
    DB_query("UPDATE {$_TABLES['conf_values']} SET sort_order = 648 WHERE sort_order = 670");
    // change default for num_search_results
    $thirty = addslashes(serialize(30));
    DB_query("UPDATE {$_TABLES['conf_values']} SET value = '$thirty', default_value = '$thirty' WHERE name = 'num_search_results'");

    $c = config::get_instance();

    // new options
    $c->add('jpeg_quality',75,'text',5,23,NULL,1495,FALSE);
    $c->add('advanced_html',array ('img' => array('width' => 1, 'height' => 1, 'src' => 1, 'align' => 1, 'valign' => 1, 'border' => 1, 'alt' => 1)),'**placeholder',7,34,NULL,1721,TRUE);

    // squeeze search options between 640 (lastlogin) and 680 (loginrequired)
    $c->add('fs_search', NULL, 'fieldset', 0, 6, NULL, 0, TRUE);
    $c->add('search_style','google','select',0,6,19,642,TRUE);
    $c->add('search_limits','10,15,25,30','text',0,6,NULL,645,TRUE);
    // see above: $c->add('num_search_results',30,'text',0,6,NULL,648,TRUE);
    $c->add('search_show_limit',TRUE,'select',0,6,1,651,TRUE);
    $c->add('search_show_sort',TRUE,'select',0,6,1,654,TRUE);
    $c->add('search_show_num',TRUE,'select',0,6,1,657,TRUE);
    $c->add('search_show_type',TRUE,'select',0,6,1,660,TRUE);
    $c->add('search_show_user',TRUE,'select',0,6,1,663,TRUE);
    $c->add('search_show_hits',TRUE,'select',0,6,1,666,TRUE);
    $c->add('search_no_data','<i>Not available...</i>','text',0,6,NULL,669,TRUE);
    $c->add('search_separator',' &gt; ','text',0,6,NULL,672,TRUE);
    $c->add('search_def_keytype','phrase','select',0,6,20,675,TRUE);
    $c->add('search_use_fulltext',FALSE,'hidden',0,6); // 678

    return true;
}

/**
 * Add new plugin-related permissions to Plugin Admin group
 *
 */
function upgrade_addPluginPermissions()
{
    global $_TABLES;

    $install_id = DB_getItem($_TABLES['features'], 'ft_id',
                             "ft_name = 'plugin.install'");
    $upload_id = DB_getItem($_TABLES['features'], 'ft_id',
                            "ft_name = 'plugin.upload'");
    $grp_id = DB_getItem($_TABLES['groups'], 'grp_id',
                         "grp_name = 'Plugin Admin'");

    if (($grp_id > 0) && ($install_id > 0) && ($upload_id > 0)) {
        DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($install_id, $grp_id)");
        DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($upload_id, $grp_id)");
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
