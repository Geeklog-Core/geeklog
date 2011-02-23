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

?>