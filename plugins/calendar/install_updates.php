<?php

function update_ConfValues_1_1_1()
{
    global $_CONF, $_CA_DEFAULT, $_CA_CONF;

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once $_CONF['path'] . 'plugins/calendar/install_defaults.php';
    
    $c = config::get_instance();

    // Autotag Usuage Defaults    
    $c->add('fs_autotag_permissions', NULL, 'fieldset', 
            0, 10, NULL, 0, true, 'calendar');
    $c->add('autotag_permissions_event', $_CA_DEFAULT['autotag_permissions_event'], '@select', 
            0, 10, 13, 10, true, 'calendar');       

    return true;
}

?>