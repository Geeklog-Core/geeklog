<?php

// Add meta tag columns to story table 
$_SQL[] = "ALTER TABLE {$_TABLES['stories']} ADD meta_description TEXT NULL AFTER frontpage, ADD meta_keywords TEXT NULL AFTER meta_description";

/**
 * Add new config options
 *
 */
function update_ConfValuesFor161()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    // meta tag config options.
    $c->add('meta_tags',0,'select',0,0,23,2000,TRUE);
    $c->add('meta_description','Geeklog, the open source content management system designed with security in mind.','text',0,0,NULL,2010,TRUE);
    $c->add('meta_keywords','Geeklog, Blog, Content Management System, CMS, Open Source, Security','text',0,0,NULL,2020,TRUE);

    return true;
}

?>
