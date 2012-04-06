<?php

function polls_update_ConfValues_2_1_2()
{
    global $_CONF, $_PO_DEFAULT, $_PO_CONF;

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    
    $c = config::get_instance();
    
    require_once $_CONF['path'] . 'plugins/polls/install_defaults.php';

    // Autotag Usuage Defaults    
    $c->add('fs_autotag_permissions', NULL, 'fieldset', 
            0, 10, NULL, 0, true, 'polls', 10);
    $c->add('autotag_permissions_poll', $_PO_DEFAULT['autotag_permissions_poll'], '@select', 
            0, 10, 13, 10, true, 'polls', 10);       
    $c->add('autotag_permissions_poll_vote', $_PO_DEFAULT['autotag_permissions_poll_vote'], '@select', 
            0, 10, 13, 10, true, 'polls', 10);       
    $c->add('autotag_permissions_poll_result', $_PO_DEFAULT['autotag_permissions_poll_result'], '@select', 
            0, 10, 13, 10, true, 'polls', 10);
    
    // Add in all the New Tabs
    $c->add('tab_main', NULL, 'tab', 0, 0, NULL, 0, true, 'polls', 0);
    $c->add('tab_whatsnew', NULL, 'tab', 0, 1, NULL, 0, true, 'polls', 1);
    $c->add('tab_permissions', NULL, 'tab', 0, 2, NULL, 0, true, 'polls', 2);
    $c->add('tab_autotag_permissions', NULL, 'tab', 0, 10, NULL, 0, true, 'polls', 10);

    return true;
}

function polls_update_ConfValues_2_1_3()
{
    global $_CONF, $_PO_DEFAULT, $_PO_CONF, $_GROUPS, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    
    $c = config::get_instance();
    
    require_once $_CONF['path'] . 'plugins/polls/install_defaults.php';

    $c->add('tab_poll_block', NULL, 'tab', 0, 20, NULL, 0, true, 'polls', 20);
    $c->add('fs_block_settings', NULL, 'fieldset', 0, 10, NULL, 0, true, 'polls', 20);
    $c->add('block_enable', $_PO_DEFAULT['block_enable'], 'select', 
            0, 10, 0, 10, true, 'polls', 20);
    $c->add('block_isleft', $_PO_DEFAULT['block_isleft'], 'select', 
            0, 10, 0, 20, true, 'polls', 20);
    $c->add('block_order', $_PO_DEFAULT['block_order'], 'text',
            0, 10, 0, 30, true, 'polls', 20);
    $c->add('block_topic_option', $_PO_DEFAULT['block_topic_option'],'select',
            0, 10, 15, 40, true, 'polls', 20);  
    $c->add('block_topic', $_PO_DEFAULT['block_topic'], '%select',
            0, 10, NULL, 50, true, 'polls', 20);

    $c->add('fs_block_permissions', NULL, 'fieldset', 0, 20, NULL, 0, true, 'polls', 20);
    $new_group_id = 0;
    if (isset($_GROUPS['Polls Admin'])) {
        $new_group_id = $_GROUPS['Polls Admin'];
    } else {
        $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Polls Admin'");
        if ($new_group_id == 0) {
            if (isset($_GROUPS['Root'])) {
                $new_group_id = $_GROUPS['Root'];
            } else {
                $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
            }
        }
    }         
    $c->add('block_group_id', $new_group_id,'select',
            0, 20, NULL, 10, TRUE, 'polls', 20);        
    $c->add('block_permissions', $_PO_DEFAULT['block_permissions'], '@select', 
            0, 20, 14, 20, true, 'polls', 20);       

    return true;
}
    
?>