<?php

function SP_update_ConfValues_1_6_3()
{
    global $_CONF, $_TABLES, $_SP_DEFAULT;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    require_once $_CONF['path'] . 'plugins/staticpages/install_defaults.php';

    // Autotag usage permissions
    $c->add('fs_autotag_permissions', NULL, 'fieldset', 
            0, 10, NULL, 0, true, 'staticpages');
    $c->add('autotag_permissions_staticpage', $_SP_DEFAULT['autotag_permissions_staticpage'], '@select', 
            0, 10, 13, 10, true, 'staticpages');       
    $c->add('autotag_permissions_staticpage_content', $_SP_DEFAULT['autotag_permissions_staticpage_content'], '@select', 
            0, 10, 13, 10, true, 'staticpages'); 
    
    return true;
}

?>