<?php

/* These queries were copied from the mysql 1.4.2 upgrade and 
 * probably need to be rewritten for MS SQL

// remove time zone table since its included into PEAR now
$_SQL[] = "DROP TABLE " . $_DB_table_prefix . 'tzcodes';
$_SQL[] = "ALTER TABLE {$_TABLES['userprefs']} CHANGE `tzid` `tzid` VARCHAR(125) NOT NULL DEFAULT ''";
// change former default values to '' so users dont all have edt for no reason
$_SQL[] = "UPDATE `{$_TABLES['userprefs']}` set tzid = ''";
// User submissions may have body text.
$_SQL[] = "ALTER TABLE `{$_TABLES['storysubmission']}` ADD bodytext TEXT AFTER introtext";

// new comment code: close comments
$_SQL[] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (1,'Comments Closed')";

// add owner-field to links-submission
$_SQL[] = "ALTER TABLE {$_TABLES['linksubmission']} ADD owner_id mediumint(8) unsigned NOT NULL default '1';";

// update plugin version numbers
$_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version = '1.1', pi_gl_version = '1.4.1' WHERE pi_name = 'links'";

// Increase block function size to accept arguments:
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} CHANGE phpblockfn phpblockfn VARCHAR(128)";

// New fields to store HTTP Last-Modified and ETag headers
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD rdf_last_modified VARCHAR(40) DEFAULT NULL AFTER rdfupdated";
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD rdf_etag VARCHAR(40) DEFAULT NULL AFTER rdf_last_modified";

 */


function create_ConfValues()
{
    global $_TABLES;
    // Create conf_values table for new configuration system
    DB_query ("
        CREATE TABLE [dbo].[{$_TABLES['conf_values']}] (
          [name] [varchar] (50) NULL,
          [value] [text] NULL,
          [type] [varchar] (50) NULL,
          [group_name] [varchar] (50) NULL,
          [default_value] [text],
          [subgroup] [int] NULL,
          [selectionArray] [int] NULL,
          [sort_order] [int] NULL,
          [fieldset] [int] NULL )
        ON [PRIMARY]
        ");
        require_once($_CONF['path_system'] . 'classes/config.class.php');
    
    $c = config::create();
    
    $c->add('path_html','','text',0,1,NULL,10,TRUE);
    $c->add('site_url','','text',0,0,NULL,20,TRUE);
    $c->add('site_admin_url','','text',0,0,NULL,30,TRUE);
    $c->add('site_mail','','text',0,3,NULL,40,TRUE);
    $c->add('noreply_mail','','text',0,3,NULL,50,TRUE);
    $c->add('site_name','','text',0,0,NULL,60,TRUE);
    $c->add('site_slogan','','text',0,0,NULL,70,TRUE);
    $c->add('microsummary_short','GL: ','text',0,0,NULL,80,TRUE);
    $c->add('path_log','','text',0,1,NULL,90,TRUE);
    $c->add('path_language','','text',0,1,NULL,100,TRUE);
    $c->add('backup_path','','text',0,1,NULL,110,TRUE);
    $c->add('path_data','','text',0,1,NULL,120,TRUE);
    $c->add('path_images','','text',0,1,NULL,130,TRUE);
    $c->add('have_pear','','select',0,4,1,135,TRUE);
    $c->add('path_pear','','text',0,4,NULL,140,TRUE);
    $c->add('mail_settings',array ('backend' => 'mail', 'sendmail_path' => '/usr/bin/sendmail', 'sendmail_args' => '', 'host' => 'smtp.example.com','port' => '25', 'auth' => false, 'username' => 'smtp-username','password' => 'smtp-password'),'@text',0,3,NULL,160,TRUE);
    $c->add('allow_mysqldump',1,'select',0,5,0,170,TRUE);
    $c->add('mysqldump_options','-Q','text',0,5,NULL,180,TRUE);
    $c->add('theme','professional','text',2,2,NULL,190,TRUE);
    $c->add('menu_elements',array('contribute','search','stats','directory','plugins'),'%text',2,2,NULL,200,TRUE);
    $c->add('path_themes','','text',2,2,NULL,210,TRUE);
    $c->add('disable_new_user_registration',FALSE,'select',4,6,0,220,TRUE);
    $c->add('allow_user_themes',1,'select',4,6,0,230,TRUE);
    $c->add('allow_user_language',1,'select',4,6,0,240,TRUE);
    $c->add('allow_user_photo',1,'select',4,6,0,250,TRUE);
    $c->add('allow_username_change',0,'select',4,6,0,260,TRUE);
    $c->add('allow_account_delete',0,'select',4,6,0,270,TRUE);
    $c->add('hide_author_exclusion',0,'select',4,6,0,280,TRUE);
    $c->add('show_fullname',0,'select',4,6,0,290,TRUE);
    $c->add('show_servicename',TRUE,'select',4,6,1,300,TRUE);
    $c->add('custom_registration',FALSE,'select',4,6,1,310,TRUE);
    $c->add('user_login_method',array('standard' => true, 'openid' => false, '3rdparty' => false),'@select',4,6,1,320,TRUE);
    $c->add('spamx',128,'text',4,8,NULL,330,TRUE);
    $c->add('sort_admin',TRUE,'select',7,9,1,340,TRUE);
    $c->add('language','english','text',6,11,NULL,350,TRUE);
    $c->add('locale','en_GB','text',6,10,NULL,360,TRUE);
    $c->add('date','%A, %B %d %Y @ %I:%M %p %Z','text',6,10,NULL,370,TRUE);
    $c->add('daytime','%m/%d %I:%M%p','text',6,10,NULL,380,TRUE);
    $c->add('shortdate','%x','text',6,10,NULL,390,TRUE);
    $c->add('dateonly','%d-%b','text',6,10,NULL,400,TRUE);
    $c->add('timeonly','%I:%M%p','text',6,10,NULL,410,TRUE);
    $c->add('week_start','Sun','text',6,10,14,420,TRUE);
    $c->add('hour_mode',12,'select',6,10,6,430,TRUE);
    $c->add('thousand_separator',",",'text',6,10,NULL,440,TRUE);
    $c->add('decimal_separator',".",'text',6,10,NULL,450,TRUE);
    $c->add('decimal_count',"2",'text',6,10,NULL,460,TRUE);
    $c->add('language_files',array('en'=>'english_utf-8', 'de'=>'german_formal_utf-8'),'*text',6,11,NULL,470,FALSE);
    $c->add('languages',array('en'=>'English', 'de'=>'Deutsch'),'*text',6,11,NULL,480,FALSE);
    $c->add('timezone','Etc/GMT-6','text',6,10,NULL,490,FALSE);
    $c->add('site_enabled',TRUE,'select',0,0,1,500,TRUE);
    $c->add('site_disabled_msg','Geeklog Site is down. Please come back soon.','text',0,0,NULL,510,TRUE);
    $c->add('rootdebug',FALSE,'select',7,12,1,520,TRUE);
    $c->add('cookie_session','gl_session','text',7,13,NULL,530,TRUE);
    $c->add('cookie_name','geeklog','text',7,13,NULL,540,TRUE);
    $c->add('cookie_password','password','text',7,13,NULL,550,TRUE);
    $c->add('cookie_theme','theme','text',7,13,NULL,560,TRUE);
    $c->add('cookie_language','language','text',7,13,NULL,570,TRUE);
    $c->add('cookie_ip',0,'select',7,13,0,580,TRUE);
    $c->add('default_perm_cookie_timeout',28800,'text',7,13,NULL,590,TRUE);
    $c->add('session_cookie_timeout',7200,'text',7,13,NULL,600,TRUE);
    $c->add('cookie_path','/','text',7,13,NULL,610,TRUE);
    $c->add('cookiedomain','','text',7,13,NULL,620,TRUE);
    $c->add('cookiesecure',0,'text',7,13,NULL,630,TRUE);
    $c->add('lastlogin',TRUE,'select',4,14,1,640,TRUE);
    $c->add('ostype',PHP_OS,'text',7,7,NULL,650,TRUE);
    $c->add('pdf_enabled',0,'select',7,7,0,660,TRUE);
    $c->add('num_search_results',10,'text',0,15,NULL,670,TRUE);
    $c->add('loginrequired',0,'select',4,14,0,680,TRUE);
    $c->add('submitloginrequired',0,'select',4,14,0,690,TRUE);
    $c->add('commentsloginrequired',0,'select',4,14,0,700,TRUE);
    $c->add('statsloginrequired',0,'select',4,14,0,710,TRUE);
    $c->add('searchloginrequired',0,'select',4,14,0,720,TRUE);
    $c->add('profileloginrequired',0,'select',4,14,0,730,TRUE);
    $c->add('emailuserloginrequired',0,'select',4,14,0,740,TRUE);
    $c->add('emailstoryloginrequired',0,'select',4,14,0,750,TRUE);
    $c->add('directoryloginrequired',0,'select',4,14,0,760,TRUE);
    $c->add('storysubmission',1,'select',4,17,0,770,TRUE);
    $c->add('usersubmission',0,'select',4,16,0,780,TRUE);
    $c->add('listdraftstories',0,'select',4,17,0,790,TRUE);
    $c->add('notification',array(),'%text',7,7,NULL,800,TRUE);
    $c->add('postmode','plaintext','select',4,17,5,810,TRUE);
    $c->add('speedlimit',45,'text',4,17,NULL,820,TRUE);
    $c->add('skip_preview',0,'text',4,17,NULL,830,TRUE);
    $c->add('advanced_editor',FALSE,'select',4,17,1,840,TRUE);
    $c->add('wikitext_editor',FALSE,'select',4,17,1,850,TRUE);
    $c->add('cron_schedule_interval',86400,'text',7,7,NULL,860,TRUE);
    $c->add('sortmethod','sortnum','text',3,18,NULL,870,TRUE);
    $c->add('showstorycount',1,'select',3,18,0,880,TRUE);
    $c->add('showsubmissioncount',1,'select',3,18,0,890,TRUE);
    $c->add('hide_home_link',0,'select',3,18,0,900,TRUE);
    $c->add('whosonline_threshold',300,'text',3,19,NULL,910,TRUE);
    $c->add('whosonline_anonymous',0,'select',3,19,0,920,TRUE);
    $c->add('emailstories',0,'select',3,20,0,930,TRUE);
    $c->add('emailstorieslength',1,'text',3,20,NULL,940,TRUE);
    $c->add('emailstoriesperdefault',0,'select',3,20,0,950,TRUE);
    $c->add('allow_domains','','text',4,16,NULL,960,TRUE);
    $c->add('disallow_domains','','text',4,16,NULL,970,TRUE);
    $c->add('newstoriesinterval',86400,'text',3,21,NULL,980,TRUE);
    $c->add('newcommentsinterval',172800,'text',3,21,NULL,990,TRUE);
    $c->add('newtrackbackinterval',172800,'text',3,21,NULL,1000,TRUE);
    $c->add('hidenewstories',0,'select',3,21,0,1010,TRUE);
    $c->add('hidenewcomments',0,'select',3,21,0,1020,TRUE);
    $c->add('hidenewtrackbacks',0,'select',3,21,0,1030,TRUE);
    $c->add('hidenewplugins',0,'select',3,21,0,1040,TRUE);
    $c->add('title_trim_length',20,'text',3,21,NULL,1050,TRUE);
    $c->add('trackback_enabled',TRUE,'select',1,22,1,1060,TRUE);
    $c->add('pingback_enabled',TRUE,'select',1,23,1,1070,TRUE);
    $c->add('ping_enabled',TRUE,'select',1,23,1,1080,TRUE);
    $c->add('trackback_code',0,'select',1,22,3,1090,TRUE);
    $c->add('multiple_trackbacks',0,'select',1,22,2,1100,TRUE);
    $c->add('trackbackspeedlimit',300,'text',1,22,NULL,1110,TRUE);
    $c->add('check_trackback_link',2,'select',1,22,4,1120,TRUE);
    $c->add('pingback_self',0,'select',1,23,13,1130,TRUE);
    $c->add('pingback_excerpt',TRUE,'select',1,23,1,1140,TRUE);
    $c->add('link_documentation',1,'select',7,9,0,1150,TRUE);
    $c->add('link_versionchecker',1,'select',7,9,0,1160,TRUE);
    $c->add('maximagesperarticle',5,'text',1,24,NULL,1170,TRUE);
    $c->add('limitnews',10,'text',1,24,NULL,1180,TRUE);
    $c->add('minnews',1,'text',1,24,NULL,1190,TRUE);
    $c->add('contributedbyline',1,'select',1,24,0,1200,TRUE);
    $c->add('hideviewscount',0,'select',1,24,0,1210,TRUE);
    $c->add('hideemailicon',0,'select',1,24,0,1220,TRUE);
    $c->add('hideprintericon',0,'select',1,24,0,1230,TRUE);
    $c->add('allow_page_breaks',1,'select',1,24,0,1240,TRUE);
    $c->add('page_break_comments','last','select',1,24,7,1250,TRUE);
    $c->add('article_image_align','right','select',1,24,8,1260,TRUE);
    $c->add('show_topic_icon',1,'select',1,24,0,1270,TRUE);
    $c->add('draft_flag',0,'select',1,24,0,1280,TRUE);
    $c->add('frontpage',1,'select',1,24,0,1290,TRUE);
    $c->add('hide_no_news_msg',0,'select',1,24,0,1300,TRUE);
    $c->add('hide_main_page_navigation',0,'select',1,24,0,1310,TRUE);
    $c->add('atom_max_stories', 10, 'text', 1, 24, 0, 1315, TRUE);
    $c->add('onlyrootfeatures',0,'select',1,24,0,1320,TRUE);
    $c->add('aftersave_story','item','select',1,24,9,1330,TRUE);
    $c->add('aftersave_user','item','select',1,24,9,1340,TRUE);
    $c->add('show_right_blocks',FALSE,'select',2,25,1,1350,TRUE);
    $c->add('showfirstasfeatured',0,'select',2,25,0,1360,TRUE);
    $c->add('left_blocks_in_footer',0,'select',2,25,0,1370,TRUE);
    $c->add('backend',1,'select',0,26,0,1380,TRUE);
    $c->add('rdf_file','','text',0,26,NULL,1390,TRUE);
    $c->add('rdf_limit',10,'text',0,26,NULL,1400,TRUE);
    $c->add('rdf_storytext',1,'text',0,26,NULL,1410,TRUE);
    $c->add('rdf_language','en-gb','text',0,26,NULL,1420,TRUE);
    $c->add('syndication_max_headlines',0,'text',0,26,NULL,1430,TRUE);
    $c->add('copyright','2007','text',0,0,NULL,1440,FALSE);
    $c->add('image_lib','','select',5,27,10,1450,TRUE);
    $c->add('path_to_mogrify','','text',5,27,NULL,1460,FALSE);
    $c->add('path_to_netpbm','','text',5,27,NULL,1470,FALSE);
    $c->add('debug_image_upload',TRUE,'select',5,28,1,1480,FALSE);
    $c->add('keep_unscaled_image',0,'select',5,28,0,1490,TRUE);
    $c->add('allow_user_scaling',1,'select',5,28,0,1500,TRUE);
    $c->add('max_image_width',160,'text',5,29,NULL,1510,TRUE);
    $c->add('max_image_height',160,'text',5,29,NULL,1520,TRUE);
    $c->add('max_image_size',1048576,'text',5,29,NULL,1530,TRUE);
    $c->add('max_topicicon_width',48,'text',5,30,NULL,1540,TRUE);
    $c->add('max_topicicon_height',48,'text',5,30,NULL,1550,TRUE);
    $c->add('max_topicicon_size',65536,'text',5,30,NULL,1560,TRUE);
    $c->add('max_photo_width',128,'text',5,31,NULL,1570,TRUE);
    $c->add('max_photo_height',128,'text',5,31,NULL,1580,TRUE);
    $c->add('max_photo_size',65536,'text',5,31,NULL,1590,TRUE);
    $c->add('use_gravatar',FALSE,'select',5,32,1,1600,TRUE);
    $c->add('gravatar_rating','R','text',5,32,NULL,1610,FALSE);
    $c->add('force_photo_width',75,'text',5,31,NULL,1620,FALSE);
    $c->add('default_photo','http://example.com/default.jpg','text',5,31,NULL,1630,FALSE);
    $c->add('commentspeedlimit',45,'text',4,33,NULL,1640,TRUE);
    $c->add('comment_limit',100,'text',4,33,NULL,1650,TRUE);
    $c->add('comment_mode','threaded','select',4,33,11,1660,TRUE);
    $c->add('comment_code',0,'select',4,33,0,1670,TRUE);
    $c->add('passwordspeedlimit',300,'text',4,14,NULL,1680,TRUE);
    $c->add('login_attempts',3,'text',4,14,NULL,1690,TRUE);
    $c->add('login_speedlimit',300,'text',4,14,NULL,1700,TRUE);
    $c->add('user_html',array ('p' => array(), 'b' => array(), 'strong' => array(),'i' => array(), 'a' => array('href' => 1, 'title' => 1, 'rel' => 1),'em'   => array(),'br'   => array(),'tt'   => array(),'hr'   => array(),    'li'   => array(), 'ol'   => array(), 'ul'   => array(), 'code' => array(), 'pre'  => array()),'**placeholder',7,34,NULL,1710,TRUE);
    $c->add('admin_html',array ('p' => array('class' => 1, 'id' => 1, 'align' => 1), 'div' => array('class' => 1, 'id' => 1), 'span' => array('class' => 1, 'id' => 1), 'table' => array('class' => 1, 'id' => 1, 'width' => 1, 'border' => 1, 'cellspacing' => 1, 'cellpadding' => 1), 'tr' => array('class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1), 'th' => array('class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1, 'colspan' => 1, 'rowspan' => 1), 'td' => array('class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1, 'colspan' => 1, 'rowspan' => 1)),'**placeholder',7,34,NULL,1720,TRUE);
    $c->add('skip_html_filter_for_root',0,'select',7,34,0,1730,TRUE);
    $c->add('allowed_protocols',array('http','ftp','https'),'%text',0,0,NULL,1740,TRUE);
    $c->add('disable_autolinks',0,'select',7,7,0,1750,TRUE);
    $c->add('censormode',1,'select',7,35,0,1760,TRUE);
    $c->add('censorreplace','*censormode*','text',7,35,NULL,1770,TRUE);
    $c->add('censorlist', array('fuck','cunt','fucker','fucking','pussy','cock','c0ck',' cum ','twat','clit','bitch','fuk','fuking','motherfucker'),'%text',7,35,NULL,1780,TRUE);
    $c->add('ip_lookup','/nettools/whois.php?domain=*','text',7,36,NULL,1790,FALSE);
    $c->add('url_rewrite',FALSE,'select',0,0,1,1800,TRUE);
    $c->add('default_permissions_block',array(3, 2, 2, 2),'@select',7,37,12,1810,TRUE);
    $c->add('default_permissions_story',array(3, 2, 2, 2),'@select',7,37,12,1820,TRUE);
    $c->add('default_permissions_topic',array(3, 2, 2, 2),'@select',7,37,12,1830,TRUE);

}

function upgrade_StaticpagesPlugin()
{
    global $_TABLES;

/*
 * This needs to be updated for MS SQL
    // Polls plugin updates
    $check_sql = "SELECT pi_name FROM {$_TABLES['plugins']} WHERE pi_name = 'staticpages';";
    $check_rst = DB_query ($check_sql);
    if (DB_numRows($check_rst) == 1) {
        $P_SQL = array();
        $P_SQL[] = "ALTER TABLE `{$_TABLES['staticpage']}` ADD commentcode tinyint(4) NOT NULL default '0' AFTER sp_label";

        INST_updateDB($P_SQL);
    }
*/
}
?>
