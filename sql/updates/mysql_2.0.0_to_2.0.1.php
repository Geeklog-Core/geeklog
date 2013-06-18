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

    // Article Related Topics    
    $c->add('related_topics',1,'select',1,7,32,1340,TRUE, $me, 7);
    $c->add('related_topics_max',6,'text',1,7,NULL,1350,TRUE, $me, 7);
    
    // Article What's Related
    $c->add('whats_related',1,'select',1,7,33,1360,TRUE, $me, 7);
    $c->add('whats_related_max',0,'text',1,7,NULL,1370,TRUE, $me, 7);
    $c->add('whats_related_trim',26,'text',1,7,NULL,1380,TRUE, $me, 7);

    // New Topic autotag permissions
    $c->add('autotag_permissions_topic', array(2, 2, 2, 2), '@select', 7, 41, 28, 1890, TRUE, $me, 37);
    $c->add('autotag_permissions_related_topics', array(2, 2, 0, 0), '@select', 7, 41, 28, 1900, TRUE, $me, 37);
    $c->add('autotag_permissions_related_items', array(2, 2, 0, 0), '@select', 7, 41, 28, 1910, TRUE, $me, 37);

    return true;
}

?>
