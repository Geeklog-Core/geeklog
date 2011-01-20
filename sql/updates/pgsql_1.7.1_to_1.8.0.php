<?php


/**
 * Add new config options
 *
 */
function update_ConfValuesFor180()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    // whosonline block
    $c->add('whosonline_photo',0,'select',3,14,0,930,TRUE);
    
    // user_login_method
    $c->del('user_login_method', 'Core');
    $c->add('user_login_method',array('standard' => $_CONF['user_login_method']['standard'] , 'openid' => $_CONF['user_login_method']['openid'] , '3rdparty' => $_CONF['user_login_method']['3rdparty'] , 'oauth' => false),'@select',4,16,1,320,TRUE);

    // OAuth Settings
    $c->add('facebook_login',0,'select',4,16,1,350,TRUE);
    $c->add('facebook_consumer_key','','text',4,16,NULL,351,TRUE);
    $c->add('facebook_consumer_secret','','text',4,16,NULL,352,TRUE);
    $c->add('linkedin_login',0,'select',4,16,1,353,TRUE);
    $c->add('linkedin_consumer_key','','text',4,16,NULL,354,TRUE);
    $c->add('linkedin_consumer_secret','','text',4,16,NULL,355,TRUE);
    $c->add('twitter_login',0,'select',4,16,1,356,TRUE);
    $c->add('twitter_consumer_key','','text',4,16,NULL,357,TRUE);
    $c->add('twitter_consumer_secret','','text',4,16,NULL,358,TRUE);  
    
    // Autotag usage permissions
    $c->add('fs_autotag_permissions', NULL, 'fieldset', 7, 41, NULL, 0, TRUE);
    $c->add('autotag_permissions_story', array(2, 2, 2, 2), '@select', 7, 41, 28, 1870, TRUE);
    $c->add('autotag_permissions_user', array(2, 2, 2, 2), '@select', 7, 41, 28, 1880, TRUE);     
    
    return true;
}

?>
