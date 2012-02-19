<?php

// Enable plugin load order
$_SQL[] = "ALTER TABLE {$_TABLES['plugins']} ADD [pi_load] [smallint] NOT NULL DEFAULT 10000";

// Add Tab column in for config
$_SQL[] = "ALTER TABLE {$_TABLES['conf_values']} ADD [tab] [int] NULL AFTER [sort_order]";
// Set new Tab column to whatever fieldset is
$_SQL[] = "UPDATE {$_TABLES['conf_values']} SET tab = fieldset WHERE group_name = 'Core'";
// Make a few corrections, let default_permissions_story share it's tab with default_permissions_topic and default_permissions_block
$_SQL[] = "UPDATE {$_TABLES['conf_values']} SET tab = 37 WHERE group_name = 'Core' AND name = 'fs_perm_topic'";
$_SQL[] = "UPDATE {$_TABLES['conf_values']} SET tab = 37 WHERE group_name = 'Core' AND name = 'default_permissions_topic'";
$_SQL[] = "UPDATE {$_TABLES['conf_values']} SET tab = 37 WHERE group_name = 'Core' AND name = 'fs_perm_block'";
$_SQL[] = "UPDATE {$_TABLES['conf_values']} SET tab = 37 WHERE group_name = 'Core' AND name = 'default_permissions_block'";

// Increase name length to 50 on features table
$_SQL[] = "ALTER TABLE {$_TABLES['features']} ALTER COLUMN [ft_name] VARCHAR(50) NOT NULL";

// Insert Group rights for configuration tabs
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_site', 'Access to configure site', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_mail', 'Access to configure mail', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_syndication', 'Access to configure syndication', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_paths', 'Access to configure paths', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_pear', 'Access to configure PEAR', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_mysql', 'Access to configure MySQL', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_search', 'Access to configure search', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_story', 'Access to configure story', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_trackback', 'Access to configure trackback', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_pingback', 'Access to configure pingback', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_theme', 'Access to configure theme', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_theme_advanced', 'Access to configure theme advanced settings', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_admin_block', 'Access to configure admin block', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_topics_block', 'Access to configure topics block', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_whosonline_block', 'Access to configure who''s online block', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_whatsnew_block', 'Access to configure what''s new block', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_users', 'Access to configure users', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_spamx', 'Access to configure Spam-x', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_login', 'Access to configure login settings', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_user_submission', 'Access to configure user submission', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_submission', 'Access to configure submission settings', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_comments', 'Access to configure comments', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_imagelib', 'Access to configure image library', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_upload', 'Access to configure upload', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_articleimg', 'Access to configure images in article', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_topicicon', 'Access to configure topic icons', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_userphoto', 'Access to configure photos', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_gravatar', 'Access to configure gravatar', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_language', 'Access to configure language', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_locale', 'Access to configure locale', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_cookies', 'Access to configure cookies', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_misc', 'Access to configure miscellaneous settings', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_debug', 'Access to configure debug', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_daily_digest', 'Access to configure daily digest', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_htmlfilter', 'Access to configure HTML filtering', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_censoring', 'Access to configure censoring', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_iplookup', 'Access to configure IP lookup', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_permissions', 'Access to configure default permissions for story, topic, block and autotags', 1)";
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.Core.tab_webservices', 'Access to configure webservices', 1)";

// Add new Core Admin Group for Configuration
$_SQL[] = "INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr, grp_gl_core) VALUES ('Configuration Admin', 'Has full access to configuration', 1);";


/**
 * Add passwords for OAuth and OpenID users
 *
 */
function update_UsersFor180()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'lib-security.php';
    require_once $_CONF['path_system'] . 'lib-user.php';
    
    $passwords = array();
    
    $sql = "SELECT uid FROM {$_TABLES['users']} WHERE (remoteservice IS NOT NULL OR remoteservice != '') AND passwd = ''";
    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    for($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        
        $passwd = null;
        SEC_updateUserPassword($passwd, $A['uid']);
    }    

}

/**
 * Add is new security rights for the new Group "Configuration Admin"
 *
 */
function update_ConfigSecurityFor180()
{
    global $_TABLES;
    
    // Add in security rights for Configuration Admins
    $group_id = DB_getItem($_TABLES['groups'], 'grp_id',
                            "grp_name = 'Configuration Admin'");

    if ($group_id > 0) {
        // Assign Config Group to Root Group
        DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES ($group_id,NULL,1)");
        
        $ft_names[] = 'config.Core.tab_site';
        $ft_names[] = 'config.Core.tab_mail';
        $ft_names[] = 'config.Core.tab_syndication';
        $ft_names[] = 'config.Core.tab_paths';
        $ft_names[] = 'config.Core.tab_pear';
        $ft_names[] = 'config.Core.tab_mysql';
        $ft_names[] = 'config.Core.tab_search';
        $ft_names[] = 'config.Core.tab_story';
        $ft_names[] = 'config.Core.tab_trackback';
        $ft_names[] = 'config.Core.tab_pingback';
        $ft_names[] = 'config.Core.tab_theme';
        $ft_names[] = 'config.Core.tab_theme_advanced';
        $ft_names[] = 'config.Core.tab_admin_block';
        $ft_names[] = 'config.Core.tab_topics_block';
        $ft_names[] = 'config.Core.tab_whosonline_block';
        $ft_names[] = 'config.Core.tab_whatsnew_block';
        $ft_names[] = 'config.Core.tab_users';
        $ft_names[] = 'config.Core.tab_spamx';
        $ft_names[] = 'config.Core.tab_login';
        $ft_names[] = 'config.Core.tab_user_submission';
        $ft_names[] = 'config.Core.tab_submission';
        $ft_names[] = 'config.Core.tab_comments';
        $ft_names[] = 'config.Core.tab_imagelib';
        $ft_names[] = 'config.Core.tab_upload';
        $ft_names[] = 'config.Core.tab_articleimg';
        $ft_names[] = 'config.Core.tab_topicicon';
        $ft_names[] = 'config.Core.tab_userphoto';
        $ft_names[] = 'config.Core.tab_gravatar';
        $ft_names[] = 'config.Core.tab_language';
        $ft_names[] = 'config.Core.tab_locale';
        $ft_names[] = 'config.Core.tab_cookies';
        $ft_names[] = 'config.Core.tab_misc';
        $ft_names[] = 'config.Core.tab_debug';
        $ft_names[] = 'config.Core.tab_daily_digest';
        $ft_names[] = 'config.Core.tab_htmlfilter';
        $ft_names[] = 'config.Core.tab_censoring';
        $ft_names[] = 'config.Core.tab_iplookup';
        $ft_names[] = 'config.Core.tab_permissions';
        $ft_names[] = 'config.Core.tab_webservices';
        
        foreach ($ft_names as $name) {
            $ft_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = '$name'");         
            if ($ft_id > 0) {
                $sql = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($ft_id, $group_id)";
                DB_query($sql);
            }
        }        
    }    

}

/**
 * Add new config options
 *
 */
function update_ConfValuesFor180()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    $me = 'Core';
    
    // whosonline block
    $c->add('whosonline_photo',0,'select',3,14,0,930,TRUE,$me,14);

    // user_login_method
    $c->del('user_login_method', 'Core');
    //$c->add('user_login_method',array('standard' => $_CONF['user_login_method']['standard'] , 'openid' => $_CONF['user_login_method']['openid'] , '3rdparty' => $_CONF['user_login_method']['3rdparty'] , 'oauth' => false),'@select',4,16,1,320,TRUE,$me,16);
    $c->add('user_login_method',array('standard' => true , 'openid' => false , '3rdparty' => false , 'oauth' => false),'@select',4,16,1,320,TRUE,$me,16);

    // OAuth Settings
    $c->add('facebook_login',0,'select',4,16,1,350,TRUE,$me,16);
    $c->add('facebook_consumer_key','','text',4,16,NULL,351,TRUE,$me,16);
    $c->add('facebook_consumer_secret','','text',4,16,NULL,352,TRUE,$me,16);
    $c->add('linkedin_login',0,'select',4,16,1,353,TRUE,$me,16);
    $c->add('linkedin_consumer_key','','text',4,16,NULL,354,TRUE,$me,16);
    $c->add('linkedin_consumer_secret','','text',4,16,NULL,355,TRUE,$me,16);
    $c->add('twitter_login',0,'select',4,16,1,356,TRUE,$me,16);
    $c->add('twitter_consumer_key','','text',4,16,NULL,357,TRUE,$me,16);
    $c->add('twitter_consumer_secret','','text',4,16,NULL,358,TRUE,$me,16);   
    
    // Autotag usage permissions - Use Permissions tab
    $c->add('fs_autotag_permissions', NULL, 'fieldset', 7, 41, NULL, 0, TRUE, $me, 37);
    $c->add('autotag_permissions_story', array(2, 2, 2, 2), '@select', 7, 41, 28, 1870, TRUE, $me, 37);
    $c->add('autotag_permissions_user', array(2, 2, 2, 2), '@select', 7, 41, 28, 1880, TRUE, $me, 37);
    
    // JavaScript use Google CDN for jQuery
    $c->add('cdn_hosted',FALSE,'select',0,0,1,1900,TRUE, $me, 0);    
    
    // Owner Name Configuration
    $c->add('owner_name','','text',0,0,NULL,1000,TRUE, $me, 0);    
    
    // Add in all the New Tabs
    $c->add('tab_site', NULL, 'tab', 0, 0, NULL, 0, TRUE, $me, 0);
    $c->add('tab_mail', NULL, 'tab', 0, 1, NULL, 0, TRUE, $me, 1);
    $c->add('tab_syndication', NULL, 'tab', 0, 2, NULL, 0, TRUE, $me, 2);
    $c->add('tab_paths', NULL, 'tab', 0, 3, NULL, 0, TRUE, $me, 3);
    $c->add('tab_pear', NULL, 'tab', 0, 4, NULL, 0, TRUE, $me, 4);
    $c->add('tab_mysql', NULL, 'tab', 0, 5, NULL, 0, TRUE, $me, 5);
    $c->add('tab_search', NULL, 'tab', 0, 6, NULL, 0, TRUE, $me, 6);
    $c->add('tab_story', NULL, 'tab', 1, 7, NULL, 0, TRUE, $me, 7);
    $c->add('tab_trackback', NULL, 'tab', 1, 8, NULL, 0, TRUE, $me, 8);
    $c->add('tab_pingback', NULL, 'tab', 1, 9, NULL, 0, TRUE, $me, 9);
    $c->add('tab_theme', NULL, 'tab', 2, 10, NULL, 0, TRUE, $me, 10);
    $c->add('tab_theme_advanced', NULL, 'tab', 2, 11, NULL, 0, TRUE, $me, 11);
    $c->add('tab_admin_block', NULL, 'tab', 3, 12, NULL, 0, TRUE, $me, 12);
    $c->add('tab_topics_block', NULL, 'tab', 3, 13, NULL, 0, TRUE, $me, 13);
    $c->add('tab_whosonline_block', NULL, 'tab', 3, 14, NULL, 0, TRUE, $me, 14);
    $c->add('tab_whatsnew_block', NULL, 'tab', 3, 15, NULL, 0, TRUE, $me, 15);
    $c->add('tab_users', NULL, 'tab', 4, 16, NULL, 0, TRUE, $me, 16);
    $c->add('tab_spamx', NULL, 'tab', 4, 17, NULL, 0, TRUE, $me, 17);
    $c->add('tab_login', NULL, 'tab', 4, 18, NULL, 0, TRUE, $me, 18);
    $c->add('tab_user_submission', NULL, 'tab', 4, 19, NULL, 0, TRUE, $me, 19);
    $c->add('tab_submission', NULL, 'tab', 4, 20, NULL, 0, TRUE, $me, 20);
    $c->add('tab_comments', NULL, 'tab', 4, 21, NULL, 0, TRUE, $me, 21);
    $c->add('tab_imagelib', NULL, 'tab', 5, 22, NULL, 0, TRUE, $me, 22);
    $c->add('tab_upload', NULL, 'tab', 5, 23, NULL, 0, TRUE, $me, 23);
    $c->add('tab_articleimg', NULL, 'tab', 5, 24, NULL, 0, TRUE, $me, 24);
    $c->add('tab_topicicon', NULL, 'tab', 5, 25, NULL, 0, TRUE, $me, 25);
    $c->add('tab_userphoto', NULL, 'tab', 5, 26, NULL, 0, TRUE, $me, 26);
    $c->add('tab_gravatar', NULL, 'tab', 5, 27, NULL, 0, TRUE, $me, 27);
    $c->add('tab_language', NULL, 'tab', 6, 28, NULL, 0, TRUE, $me, 28);
    $c->add('tab_locale', NULL, 'tab', 6, 29, NULL, 0, TRUE, $me, 29);
    $c->add('tab_cookies', NULL, 'tab', 7, 30, NULL, 0, TRUE, $me, 30);
    $c->add('tab_misc', NULL, 'tab', 7, 31, NULL, 0, TRUE, $me, 31);
    $c->add('tab_debug', NULL, 'tab', 7, 32, NULL, 0, TRUE, $me, 32);
    $c->add('tab_daily_digest', NULL, 'tab', 7, 33, NULL, 0, TRUE, $me, 33);
    $c->add('tab_htmlfilter', NULL, 'tab', 7, 34, NULL, 0, TRUE, $me, 34);
    $c->add('tab_censoring', NULL, 'tab', 7, 35, NULL, 0, TRUE, $me, 35);
    $c->add('tab_iplookup', NULL, 'tab', 7, 36, NULL, 0, TRUE, $me, 36);
    $c->add('tab_permissions', NULL, 'tab', 7, 37, NULL, 0, TRUE, $me, 37);
    $c->add('tab_webservices', NULL, 'tab', 7, 40, NULL, 0, TRUE, $me, 40);
    
    return true;
}

?>
