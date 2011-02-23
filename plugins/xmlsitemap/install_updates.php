<?php

function xmlsitemap_update_ConfValues_1_0_0()
{
    global $_CONF;

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    
    $c = config::get_instance();
    
    $me = 'xmlsitemap';
        
    // Add in all the New Tabs
    $c->add('tab_main', NULL, 'tab', 0, 0, NULL, 0, TRUE, $me, 0);
    $c->add('tab_pri', NULL, 'tab', 0, 1, NULL, 0, TRUE, $me, 1);
    $c->add('tab_freq', NULL, 'tab', 0, 2, NULL, 0, TRUE, $me, 2);

    return true;
}

?>