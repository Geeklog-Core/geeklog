<?php

function spamx_update_ConfValues_1_2_1()
{
    global $_CONF;

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    
    $c = config::get_instance();
    
    // Add in all the New Tabs
    $c->add('tab_main', NULL, 'tab', 0, 0, NULL, 0, true, 'spamx', 0);

    return true;
}

?>