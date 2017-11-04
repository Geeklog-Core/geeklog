<?php

// Add meta_description and meta_keywords to storysubmission
$_SQL[] = "ALTER TABLE {$_TABLES['storysubmission']} ADD `meta_description` TEXT NULL AFTER `postmode`";
$_SQL[] = "ALTER TABLE {$_TABLES['storysubmission']} ADD `meta_keywords` TEXT NULL AFTER `meta_description`";

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
