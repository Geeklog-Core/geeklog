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
    global $_CONF;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    // new option
    $c->add('jpeg_quality',75,'text',5,23,NULL,1495,FALSE);
    $c->add('advanced_html',array ('img' => array('width' => 1, 'height' => 1, 'src' => 1, 'align' => 1, 'valign' => 1, 'border' => 1, 'alt' => 1)),'**placeholder',7,34,NULL,1721,TRUE);

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

?>
