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
    
    // New OAuth Service
    $c->add('github_login',0,'select',4,16,1,368,TRUE, $me, 16);
    $c->add('github_consumer_key','','text',4,16,NULL,369,TRUE, $me, 16);
    $c->add('github_consumer_secret','','text',4,16,NULL,370,TRUE, $me, 16);

    // New mobile cache
    $c->add('cache_templates',TRUE,'select',2,10,1,220,TRUE, $me, 10);    

    return true;
}

?>
