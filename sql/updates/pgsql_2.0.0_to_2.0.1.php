<?php

// Delete anonymous user comment settings since all 3 are now config options
$_SQL[] = "DELETE FROM {$_TABLES['usercomment']} WHERE uid = 1";

/**
 * Add new config options
 *
 */
function update_ConfValuesFor201()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    $me = 'Core';
    
    // Default Comment Order
    $c->add('comment_order','ASC','select',4,21,31,1665,TRUE, $me, 21);
    
    // Caching Template Library Options
    $c->add('cache_templates',TRUE,'select',2,10,1,220,TRUE, $me, 10);
    $c->add('template_comments',FALSE,'select',2,11,1,1370,TRUE, $me, 11);       

    return true;
}

?>
