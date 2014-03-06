<?php

// Delete anonymous user comment settings since all 3 are now config options
$_SQL[] = "DELETE FROM {$_TABLES['usercomment']} WHERE uid = 1";

// Add Cache Time variable to Blocks table
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD `cache_time` INT NOT NULL DEFAULT '0' AFTER `allow_autotags`"; 

// Add Cache Time variable to Stories table
$_SQL[] = "ALTER TABLE {$_TABLES['stories']} ADD `cache_time` INT NOT NULL DEFAULT '0' AFTER `meta_keywords`"; 

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

// Add Filemanager
function update_addFilemanager()
{
    global $_CONF, $_TABLES;

    $configAdminId = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Configuration Admin' ");
    $storyAdminId = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Story Admin' ");

    // Add Filemanager Admin group
    DB_query("INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (null, 'Filemanager Admin', 'Has full access to File Manager', 1);");
    $groupId = DB_insertId();

    // Add features
    $featureIds = array();

    DB_query("INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (null, 'filemanager.admin', 'Ability to use File Manager', 0)");
    $featureIds['filemanager.admin'] = DB_insertId();
    DB_query("INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (null, 'config.Filemanager.tab_general', 'Access to configure Filemanager General Settings', 0)");
    $featureIds['config.Filemanager.tab_general'] = DB_insertId();
    DB_query("INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (null, 'config.Filemanager.tab_upload', 'Access to configure Filemanager Upload Settings', 0)");
    $featureIds['config.Filemanager.tab_upload'] = DB_insertId();
    DB_query("INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (null, 'config.Filemanager.tab_images', 'Access to configure Filemanager Images Settings', 0)");
    $featureIds['config.Filemanager.tab_images'] = DB_insertId();
    DB_query("INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (null, 'config.Filemanager.tab_videos', 'Access to configure Filemanager Videos Settings', 0)");
    $featureIds['config.Filemanager.tab_videos'] = DB_insertId();
    DB_query("INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (null, 'config.Filemanager.tab_audios', 'Access to configure Filemanager Audios Settings', 0)");
    $featureIds['config.Filemanager.tab_audios'] = DB_insertId();

    // Add access rights
    DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ({$featureIds['filemanager.admin']}, {$groupId}) ");
    DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ({$featureIds['filemanager.admin']}, {$storyAdminId}) ");
    DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ({$featureIds['config.Filemanager.tab_general']}, {$configAdminId}) ");
	DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ({$featureIds['config.Filemanager.tab_upload']}, {$configAdminId}) ");
	DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ({$featureIds['config.Filemanager.tab_images']}, {$configAdminId}) ");
	DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ({$featureIds['config.Filemanager.tab_videos']}, {$configAdminId}) ");
	DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ({$featureIds['config.Filemanager.tab_audios']}, {$configAdminId}) ");

    // Add group assignment
    DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES ({$groupId}, NULL, 1) ");
}

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
    
    // Remove path_themes (the location of the layout directory since hardcoded now)
    $c->del('path_themes', 'Core');
    
    // Default Cache Times
    $c->add('default_cache_time_article',0,'text',1,7,NULL,1390,TRUE, $me, 7);
    $c->add('default_cache_time_block',0,'text',7,31,NULL,1810,TRUE, $me, 31);
    
    // Title To Id Option for supported Admin Editors
    $c->add('titletoid',0,'select',7,31,1,1820,TRUE, $me, 31);

    // Subgroup: File Manager
    // subgroup
    $sg  =  (int) DB_getItem($_TABLES['conf_values'], "MAX(subgroup)" ) + 1;

    // fieldset
    $fs  = (int) DB_getItem($_TABLES['conf_values'], "MAX(fieldset)") + 1;

    // tab
    $tab = (int) DB_getItem($_TABLES['conf_values'], "MAX(tab)") + 1;
    
    // sort
    $so  = (int) DB_getItem($_TABLES['conf_values'], "MAX(sort_order)") + 10;

    // Subgroup: File Manager - General Settings
    $c->add('sg_filemanager', NULL, 'subgroup', $sg, $fs, NULL, 0, TRUE, $me, 0);

    $c->add('tab_filemanager_general', NULL, 'tab', $sg, $fs, NULL, 0, TRUE, $me, $tab);
    $c->add('fs_filemanager_general', NULL, 'fieldset', $sg, $fs, NULL, 0, TRUE, $me, $tab);

    $c->add('filemanager_disabled', FALSE, 'select', $sg, $fs, 1, $so, TRUE, $me, $tab);
    $so += 10;
    $c->add('filemanager_browse_only', FALSE, 'select', $sg, $fs, 1, $so, TRUE, $me, $tab);
    $so += 10;
    $c->add('filemanager_default_view_mode', 'grid', 'select', $sg, $fs, 34, $so, TRUE, $me, $tab);
    $so += 10;
    $c->add('filemanager_show_confirmation', TRUE, 'select', $sg, $fs, 1, $so, TRUE, $me, $tab);
    $so += 10;
    $c->add('filemanager_search_box', TRUE, 'select', $sg, $fs, 1, $so, TRUE, $me, $tab);
    $so += 10;
    $c->add('filemanager_file_sorting', 'default', 'select', $sg, $fs, 35, $so, TRUE, $me, $tab);
    $so += 10;
    $c->add('filemanager_chars_only_latin', TRUE, 'select', $sg, $fs, 1, $so, TRUE, $me, $tab);
    $so += 10;
    $c->add('filemanager_date_format', 'Y-m-d H:i:s', 'text', $sg, $fs, NULL, $so, TRUE, $me, $tab);
    $so += 10;
    $c->add('filemanager_logger', FALSE, 'select', $sg, $fs, 1, $so, TRUE, $me, $tab);
    $so += 10;
    $c->add('filemanager_show_thumbs', TRUE, 'select', $sg, $fs, 1, $so, TRUE, $me, $tab);
    $so += 10;
    $c->add('filemanager_generate_thumbnails', TRUE, 'select', $sg, $fs, 1, $so, TRUE, $me, $tab);
    $so += 10;

    // Subgroup: File Manager - Upload
    $fs++;
    $tab++;

    $c->add('tab_filemanager_upload', NULL, 'tab', $sg, $fs, NULL, 0, TRUE, $me, $tab);
    $c->add('fs_filemanager_upload', NULL, 'fieldset', $sg, $fs, NULL, 0, TRUE, $me, $tab);

    $c->add('filemanager_upload_restrictions', array('jpg', 'jpeg', 'gif', 'png', 'svg', 'txt', 'pdf', 'odp', 'ods', 'odt', 'rtf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'ogv', 'mp4', 'webm', 'ogg', 'mp3', 'wav'), '%text', $sg, $fs, NULL, $so, TRUE, $me, $tab);
    $so += 10;
    $c->add('filemanager_upload_overwrite', FALSE, 'select', $sg, $fs, 1, $so, TRUE, $me, $tab);
    $so += 10;
    $c->add('filemanager_upload_images_only', FALSE, 'select', $sg, $fs, 1, $so, TRUE, $me, $tab);
    $so += 10;
    $c->add('filemanager_upload_file_size_limit', 16, 'text', $sg, $fs, NULL, $so, TRUE, $me, $tab);
    $so += 10;
    $c->add('filemanager_unallowed_files', array('.htaccess'), '%text', $sg, $fs, NULL, $so, TRUE, $me, $tab);
    $so += 10;
    $c->add('filemanager_unallowed_dirs', array('_thumbs', '.CDN_ACCESS_LOGS', 'cloudservers'), '%text', $sg, $fs, NULL, $so, TRUE, $me, $tab);
    $so += 10;
    $c->add('filemanager_unallowed_files_regexp', '/^\\./uis', 'text', $sg, $fs, NULL, $so, TRUE, $me, $tab);
    $so += 10;
    $c->add('filemanager_unallowed_dirs_regexp', '/^\\./uis', 'text', $sg, $fs, NULL, $so, TRUE, $me, $tab);
    $so += 10;

    // Subgroup: File Manager - Images
    $fs++;
    $tab++;

    $c->add('tab_filemanager_images', NULL, 'tab', $sg, $fs, NULL, 0, TRUE, $me, $tab);
    $c->add('fs_filemanager_images', NULL, 'fieldset', $sg, $fs, NULL, 0, TRUE, $me, $tab);

    $c->add('filemanager_images_ext', array('jpg', 'jpeg', 'gif', 'png', 'svg'), '%text', $sg, $fs, NULL, $so, TRUE, $me, $tab);
    $so += 10;

    // Subgroup: File Manager - Videos
    $fs++;
    $tab++;

    $c->add('tab_filemanager_videos', NULL, 'tab', $sg, $fs, NULL, 0, TRUE, $me, $tab);
    $c->add('fs_filemanager_videos', NULL, 'fieldset', $sg, $fs, NULL, 0, TRUE, $me, $tab);

    $c->add('filemanager_show_video_player', TRUE, 'select', $sg, $fs, 1, $so, TRUE, $me, $tab);
    $so += 10;
    $c->add('filemanager_videos_ext', array('ogv', 'mp4', 'webm'), '%text', $sg, $fs, NULL, $so, TRUE, $me, $tab);
    $so += 10;
    $c->add('filemanager_videos_player_width', 400, 'text', $sg, $fs, NULL, $so, TRUE, $me, $tab);
    $so += 10;
    $c->add('filemanager_videos_player_height', 222, 'text', $sg, $fs, NULL, $so, TRUE, $me, $tab);
    $so += 10;

    // Subgroup: File Manager - Audios
    $fs++;
    $tab++;

    $c->add('tab_filemanager_audios', NULL, 'tab', $sg, $fs, NULL, 0, TRUE, $me, $tab);
    $c->add('fs_filemanager_audios', NULL, 'fieldset', $sg, $fs, NULL, 0, TRUE, $me, $tab);

    $c->add('filemanager_show_audio_player', TRUE, 'select', $sg, $fs, 1, $so, TRUE, $me, $tab);
    $so += 10;
    $c->add('filemanager_audios_ext', array('ogg', 'mp3', 'wav'), '%text', $sg, $fs, NULL, $so, TRUE, $me, $tab);
    $so += 10;

    return true;
}

?>
