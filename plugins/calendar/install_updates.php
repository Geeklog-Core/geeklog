<?php

function calendar_update_ConfValues_1_1_1()
{
    global $_CONF, $_CA_DEFAULT, $_CA_CONF;

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    
    $c = config::get_instance();
    
    require_once $_CONF['path'] . 'plugins/calendar/install_defaults.php';

    // Autotag Usuage Defaults    
    $c->add('fs_autotag_permissions', NULL, 'fieldset', 
            0, 10, NULL, 0, true, 'calendar', 10);
    $c->add('autotag_permissions_event', $_CA_DEFAULT['autotag_permissions_event'], '@select', 
            0, 10, 13, 10, true, 'calendar', 10);       
    
    // Add in all the New Tabs
    $c->add('tab_main', NULL, 'tab', 0, 0, NULL, 0, true, 'calendar', 0);
    $c->add('tab_permissions', NULL, 'tab', 0, 1, NULL, 0, true, 'calendar', 1);
    $c->add('tab_autotag_permissions', NULL, 'tab', 0, 10, NULL, 0, true, 'calendar', 10);

    return true;
}

?>