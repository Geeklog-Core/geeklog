<?php

// Delete anonymous user comment settings since all 3 are now config options
$_SQL[] = "DELETE FROM {$_TABLES['usercomment']} WHERE uid = 1";

// Add Cache Time variable to Blocks table
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD `cache_time` INT NOT NULL DEFAULT '0' AFTER `allow_autotags`"; 

// Remove unused columns in Comments table
$_SQL[] = "ALTER TABLE {$_TABLES['comments']}  DROP `score`, DROP `reason`"; 

// Add version of GLText engine to stories table
$_SQL[] = "ALTER TABLE {$_TABLES['stories']} ADD `text_version` tinyint(2) unsigned NOT NULL DEFAULT '1' AFTER `bodytext`";

// Add version of GLText engine to storysubmission table
$_SQL[] = "ALTER TABLE {$_TABLES['storysubmission']} ADD `text_version` tinyint(2) unsigned NOT NULL DEFAULT '1' AFTER `bodytext`";

// Update all topic ids and Topic name to 128 characters
$_SQL[] = "ALTER TABLE {$_TABLES['topics']} CHANGE `tid` `tid` VARCHAR(128) NOT NULL";
$_SQL[] = "ALTER TABLE {$_TABLES['topics']} CHANGE `topic` `topic` VARCHAR(128) NULL DEFAULT NULL";
$_SQL[] = "ALTER TABLE {$_TABLES['topics']} CHANGE `parent_id` `parent_id` VARCHAR(128) NOT NULL DEFAULT 'root'";
$_SQL[] = "ALTER TABLE {$_TABLES['topic_assignments']} CHANGE `tid` `tid` VARCHAR(128) NOT NULL";
$_SQL[] = "ALTER TABLE {$_TABLES['topic_assignments']} CHANGE `id` `id` VARCHAR(128) NOT NULL";
$_SQL[] = "ALTER TABLE {$_TABLES['sessions']} CHANGE `topic` `topic` VARCHAR(128) NOT NULL DEFAULT ''";
$_SQL[] = "ALTER TABLE {$_TABLES['syndication']} CHANGE `topic` `topic` VARCHAR(128) NOT NULL DEFAULT '::all'";
$_SQL[] = "ALTER TABLE {$_TABLES['syndication']} CHANGE `header_tid` `header_tid` VARCHAR(128) NOT NULL DEFAULT 'none'";

// Update all article ids to 128 characters
$_SQL[] = "ALTER TABLE {$_TABLES['article_images']} CHANGE `ai_sid` `ai_sid` VARCHAR(128) NOT NULL";
$_SQL[] = "ALTER TABLE {$_TABLES['comments']} CHANGE `sid` `sid` VARCHAR(128) NOT NULL DEFAULT ''";
$_SQL[] = "ALTER TABLE {$_TABLES['commentsubmissions']} CHANGE `sid` `sid` VARCHAR(128) NOT NULL";
$_SQL[] = "ALTER TABLE {$_TABLES['stories']} CHANGE `sid` `sid` VARCHAR(128) NOT NULL DEFAULT ''";
$_SQL[] = "ALTER TABLE {$_TABLES['trackback']} CHANGE `sid` `sid` VARCHAR(128) NOT NULL";

// Clear out Older Stories Block
$_SQL[] = "UPDATE {$_TABLES['blocks']} SET `content` = '' WHERE name = 'older_stories'";

/**
 * Add new config options
 *
 */
function update_ConfValuesFor210()
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
    
    // What's New Block
    $c->add('whatsnew_cache_time',3600,'text',3,15,NULL,1060,TRUE, $me, 15);    

    // New Topic autotag permissions
    $c->add('autotag_permissions_topic', array(2, 2, 2, 2), '@select', 7, 41, 28, 1890, TRUE, $me, 37);
    $c->add('autotag_permissions_related_topics', array(2, 2, 0, 0), '@select', 7, 41, 28, 1900, TRUE, $me, 37);
    $c->add('autotag_permissions_related_items', array(2, 2, 0, 0), '@select', 7, 41, 28, 1910, TRUE, $me, 37);
    
    // Update Language Configuration
    $c->del('allow_user_language', 'Core');
    $c->add('allow_user_language', 1,'select',6,28,0,360,TRUE, $me, 28); // Move from Users and Submissions to Language
    $c->add('fs_multilanguage', NULL, 'fieldset', 6, 29, NULL, 0, TRUE, $me, 28);
    $c->del('language_files', 'Core');
    $c->add('language_files',array('en'=>'english_utf-8', 'de'=>'german_formal_utf-8'),'*text',6,29,NULL,470,FALSE, $me, 28);
    $c->del('languages', 'Core');
    $c->add('languages',array('en'=>'English', 'de'=>'Deutsch'),'*text',6,29,NULL,480,FALSE, $me, 28);

    // New OAuth Services 
    $c->add('google_login',0,'select',4,16,1,359,TRUE, $me, 16);
    $c->add('google_consumer_key','','text',4,16,NULL,360,TRUE, $me, 16);
    $c->add('google_consumer_secret','','text',4,16,NULL,361,TRUE, $me, 16);    
    $c->add('microsoft_login',0,'select',4,16,1,362,TRUE, $me, 16);
    $c->add('microsoft_consumer_key','','text',4,16,NULL,363,TRUE, $me, 16);
    $c->add('microsoft_consumer_secret','','text',4,16,NULL,364,TRUE, $me, 16);
    $c->add('yahoo_login',0,'select',4,16,1,365,TRUE, $me, 16);
    $c->add('yahoo_consumer_key','','text',4,16,NULL,366,TRUE, $me, 16);
    $c->add('yahoo_consumer_secret','','text',4,16,NULL,367,TRUE, $me, 16);      

    // Advanced Editor Options
    $c->add('path_editors','','text',0,3,NULL,132,TRUE, $me, 3);
    $c->add('advanced_editor_name','ckeditor','select',4,20,NULL,845,TRUE, $me, 20);

    return true;
}

?>
