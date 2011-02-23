<?php

function SP_update_ConfValues_1_6_3()
{
    global $_CONF, $_TABLES, $_SP_DEFAULT;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

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

?>