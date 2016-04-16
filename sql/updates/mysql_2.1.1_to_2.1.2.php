<?php

// No Geeklog tables to change or add yet
//$_SQL[] = "";


/**
 * Add new config options
 *
 */
function update_ConfValuesFor212()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    $me = 'Core';

    // Add extra setting to hide_main_page_navigation
    $c->del('hide_main_page_navigation', $me);
    $c->add('hide_main_page_navigation','false','select',1,7,36,1310,TRUE, $me, 7);

    return true;
}

?>
