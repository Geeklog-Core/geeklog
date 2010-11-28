<?php

function update_ConfValues_2_1_2()
{
    global $_CONF, $_PO_DEFAULT, $_PO_CONF;

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once $_CONF['path'] . 'plugins/polls/install_defaults.php';
    
    $c = config::get_instance();

    // Autotag Usuage Defaults    
    $c->add('fs_autotag_permissions', NULL, 'fieldset', 
            0, 10, NULL, 0, true, 'polls');
    $c->add('autotag_permissions_poll', $_PO_DEFAULT['autotag_permissions_poll'], '@select', 
            0, 10, 13, 10, true, 'polls');       
    $c->add('autotag_permissions_poll_vote', $_PO_DEFAULT['autotag_permissions_poll_vote'], '@select', 
            0, 10, 13, 10, true, 'polls');       
    $c->add('autotag_permissions_poll_result', $_PO_DEFAULT['autotag_permissions_poll_result'], '@select', 
            0, 10, 13, 10, true, 'polls');     

    return true;
}

?>