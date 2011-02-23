<?php

function links_update_ConfValues_2_1_0()
{
    global $_CONF, $_LI_DEFAULT, $_LI_CONF;

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    
    $c = config::get_instance();

    require_once $_CONF['path'] . 'plugins/links/install_defaults.php';
    
    // Autotag Usuage Defaults    
    $c->add('fs_autotag_permissions', NULL, 'fieldset', 
            0, 10, NULL, 0, true, 'links', 10);
    $c->add('autotag_permissions_link', $_LI_DEFAULT['autotag_permissions_link'], '@select', 
            0, 10, 13, 10, true, 'links', 10);     
    
    // Add in all the New Tabs
    $c->add('tab_public', NULL, 'tab', 0, 0, NULL, 0, true, 'links', 0);
    $c->add('tab_admin', NULL, 'tab', 0, 1, NULL, 0, true, 'links', 1);
    $c->add('tab_permissions', NULL, 'tab', 0, 2, NULL, 0, true, 'links', 2);
    $c->add('tab_cpermissions', NULL, 'tab', 0, 3, NULL, 0, true, 'links', 3);
    $c->add('tab_autotag_permissions', NULL, 'tab', 0, 10, NULL, 0, true, 'links', 10);

    return true;
}

?>