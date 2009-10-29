<?php

// Add meta tag columns to story table 
$_SQL[] = "ALTER TABLE {$_TABLES['stories']} ADD [meta_description] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL AFTER frontpage, ADD [meta_keywords] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL AFTER meta_description";

// Add meta tag columns to topics table 
$_SQL[] = "ALTER TABLE {$_TABLES['topics']} ADD [meta_description] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL AFTER imageurl, ADD [meta_keywords] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL AFTER meta_description";

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

    // new option to enable / disable closing of comments after x days
    $c->add('article_comment_close_enabled',0,'select',4,21,0, 1685, TRUE);

    return true;
}

?>
