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

function spamx_update_ConfValues_1_2_2()
{
    global $_CONF, $_SPX_DEFAULT;
    
    // Now add in new Config options
    require_once $_CONF['path_system'] . 'classes/config.class.php';
    
    $c = config::get_instance();
    
    require_once $_CONF['path'] . 'plugins/spamx/install_defaults.php';
    
    // Add in new config options
    $c->add('tab_modules', NULL, 'tab', 0, 0, NULL, 0, true, 'spamx', 10);
    $c->add('fs_sfs', NULL, 'fieldset', 0, 0, NULL, 0, true, 'spamx', 10);
    $c->add('sfs_enabled', $_SPX_DEFAULT['sfs_enabled'], 'select',
            0, 0, 1, 10, true, 'spamx', 10);        
    $c->add('fs_snl', NULL, 'fieldset', 0, 10, NULL, 0, true, 'spamx', 10);
    $c->add('snl_enabled', $_SPX_DEFAULT['snl_enabled'], 'select', 
            0, 10, 1, 10, true, 'spamx', 10);     
    $c->add('snl_num_links', $_SPX_DEFAULT['snl_num_links'], 'text', 
            0, 10, NULL, 20, true, 'spamx', 10);     
    
    return true;
}

?>