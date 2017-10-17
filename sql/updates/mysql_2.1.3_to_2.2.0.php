<?php

/**
 * Database Updates
 */
// None yet
//$_SQL[] = "";


/**
 * Upgrade Messages
 */
// None yet
// function upgrade_message220() { }


/**
 * Add new config options
 */
function update_ConfValuesFor220()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    $me = 'Core';

    // Add switch language redirect option
    $c->add('switchlang_homepage',0,'select',6,28,0,370,TRUE, $me, 28);

    return true;
}
