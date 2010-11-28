<?php

function update_ConfValues_2_1_0()
{
    global $_CONF, $_LI_DEFAULT, $_LI_CONF;

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once $_CONF['path'] . 'plugins/links/install_defaults.php';
    
    $c = config::get_instance();

    // Autotag Usuage Defaults    
    $c->add('fs_autotag_permissions', NULL, 'fieldset', 
            0, 10, NULL, 0, true, 'links');
    $c->add('autotag_permissions_link', $_LI_DEFAULT['autotag_permissions_link'], '@select', 
            0, 10, 13, 10, true, 'links');     

    return true;
}

?>