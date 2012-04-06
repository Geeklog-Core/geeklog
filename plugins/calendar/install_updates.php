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

function calendar_update_ConfValues_1_1_2()
{
    global $_CONF, $_CA_DEFAULT, $_CA_CONF, $_GROUPS, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    
    $c = config::get_instance();
    
    require_once $_CONF['path'] . 'plugins/calendar/install_defaults.php';

    $c->add('tab_events_block', NULL, 'tab', 0, 20, NULL, 0, true, 'calendar', 20);
    $c->add('fs_block_settings', NULL, 'fieldset', 0, 10, NULL, 0, true, 'calendar', 20);
    $c->add('block_enable', $_CA_DEFAULT['block_enable'], 'select', 
            0, 10, 0, 10, true, 'calendar', 20);
    $c->add('block_isleft', $_CA_DEFAULT['block_isleft'], 'select', 
            0, 10, 0, 20, true, 'calendar', 20);
    $c->add('block_order', $_CA_DEFAULT['block_order'], 'text',
            0, 10, 0, 30, true, 'calendar', 20);
    $c->add('block_topic_option', $_CA_DEFAULT['block_topic_option'],'select',
            0, 10, 15, 40, true, 'calendar', 20);  
    $c->add('block_topic', $_CA_DEFAULT['block_topic'], '%select',
            0, 10, NULL, 50, true, 'calendar', 20);
    
    $c->add('fs_block_permissions', NULL, 'fieldset', 0, 20, NULL, 0, true, 'calendar', 20);
    $new_group_id = 0;
    if (isset($_GROUPS['Calendar Admin'])) {
        $new_group_id = $_GROUPS['Calendar Admin'];
    } else {
        $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Calendar Admin'");
        if ($new_group_id == 0) {
            if (isset($_GROUPS['Root'])) {
                $new_group_id = $_GROUPS['Root'];
            } else {
                $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
            }
        }
    }         
    $c->add('block_group_id', $new_group_id,'select',
            0, 20, NULL, 10, TRUE, 'calendar', 20);        
    $c->add('block_permissions', $_CA_DEFAULT['block_permissions'], '@select', 
            0, 20, 14, 20, true, 'calendar', 20);      

    return true;
}

?>