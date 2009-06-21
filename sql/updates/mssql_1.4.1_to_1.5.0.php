<?php

/* These queries were copied from the mysql 1.5.0 upgrade and
 * probably need to be rewritten for MS SQL
 */

// remove time zone table since its included into PEAR now
$_SQL[] = "DROP TABLE " . $_DB_table_prefix . 'tzcodes';
$_SQL[] = "ALTER TABLE {$_TABLES['userprefs']} ALTER COLUMN [tzid] VARCHAR(125) NOT NULL";
$_SQL[] = "ALTER TABLE {$_TABLES['userprefs']} ADD CONSTRAINT [DF_{$_TABLES['userprefs']}_tzid] DEFAULT ('') FOR [tzid]";
// change former default values to '' so users dont all have edt for no reason
$_SQL[] = "UPDATE {$_TABLES['userprefs']} set tzid = ''";
// Add new field to track the number of reminders to login and use the site or account may be deleted
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD num_reminders TINYINT NOT NULL default 0";
// User submissions may have body text.
$_SQL[] = "ALTER TABLE {$_TABLES['storysubmission']} ADD bodytext TEXT";

// new comment code: close comments
$_SQL[] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (1,'Comments Closed')";

// Increase block function size to accept arguments:
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ALTER COLUMN [phpblockfn] VARCHAR(128)";

// New fields to store HTTP Last-Modified and ETag headers
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD rdf_last_modified VARCHAR(40) DEFAULT NULL";
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD rdf_etag VARCHAR(40) DEFAULT NULL";

// new 'webservices.atompub' feature
$_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('webservices.atompub', 'May use Atompub Webservices (if restricted)', 1)";

// add the 'Webservices Users' group
$_SQL[] = "INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr, grp_gl_core) VALUES ('Webservices Users', 'Can use the Webservices API (if restricted)', 0)";
 
// add the security tokens table:
$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['tokens']}] (
    [token] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    [created] [datetime] NOT NULL,
    [owner_id] [numeric] (8,0) NOT NULL,
    [urlfor] [varchar] (2000) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
    [ttl] numeric(8,0) NOT NULL DEFAULT 1
) ON [PRIMARY]
";
 
$_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['tokens']}] ADD
    CONSTRAINT [PK_{$_TABLES['tokens']}] PRIMARY KEY  CLUSTERED
    (
        [token]
    )  ON [PRIMARY]
";


function create_ConfValues()
{
    global $_CONF, $_TABLES;

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
        
    DB_query ("
        ALTER function [DESCRIBE](@d as varchar(100)='', @c as varchar(100)=null)
        RETURNS table AS

        RETURN
        (select top 1000 a.name as Field, c.name +'(' + cast(a.prec as varchar) + ')' as Type,
        case when a.status=(0x08) then 'NULL' else '' end as [Null],
        ' ' as [Key],
        ' ' as [Default],
        ' ' as [Extra]
        from syscolumns a
        join sysobjects b on a.id=b.id
        join systypes c on a.xtype=c.xtype
        where b.name = @d
        AND (a.name=@c OR @c IS NULL)
        order by colorder asc)
       ");

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    // Subgroup: Site
    $c->add('sg_site', NULL, 'subgroup', 0, 0, NULL, 0, TRUE);

    $c->add('fs_site', NULL, 'fieldset', 0, 0, NULL, 0, TRUE);
    $c->add('site_url','','text',0,0,NULL,20,TRUE);
    $c->add('site_admin_url','','text',0,0,NULL,30,TRUE);
    $c->add('site_name','','text',0,0,NULL,60,TRUE);
    $c->add('site_slogan','','text',0,0,NULL,70,TRUE);
    $c->add('microsummary_short','GL: ','text',0,0,NULL,80,TRUE);
    $c->add('site_disabled_msg','Geeklog Site is down. Please come back soon.','text',0,0,NULL,510,TRUE);
    $c->add('copyrightyear','2008','text',0,0,NULL,1440,FALSE);
    $c->add('url_rewrite',FALSE,'select',0,0,1,1800,TRUE);

    $c->add('fs_mail', NULL, 'fieldset', 0, 1, NULL, 0, TRUE);
    $c->add('site_mail','','text',0,1,NULL,40,TRUE);
    $c->add('noreply_mail','','text',0,1,NULL,50,TRUE);
    $c->add('mail_settings',array ('backend' => 'mail', 'sendmail_path' => '/usr/bin/sendmail', 'sendmail_args' => '', 'host' => 'smtp.example.com','port' => '25', 'auth' => false, 'username' => 'smtp-username','password' => 'smtp-password'),'@text',0,1,NULL,160,TRUE);

    $c->add('fs_syndication', NULL, 'fieldset', 0, 2, NULL, 0, TRUE);
    $c->add('backend',1,'select',0,2,0,1380,TRUE);
    $c->add('rdf_file','','text',0,2,NULL,1390,TRUE);
    $c->add('rdf_limit',10,'text',0,2,NULL,1400,TRUE);
    $c->add('rdf_storytext',1,'text',0,2,NULL,1410,TRUE);
    $c->add('rdf_language','en-gb','text',0,2,NULL,1420,TRUE);
    $c->add('syndication_max_headlines',0,'text',0,2,NULL,1430,TRUE);

    $c->add('fs_paths', NULL, 'fieldset', 0, 3, NULL, 0, TRUE);
    $c->add('path_html','','text',0,3,NULL,10,TRUE);
    $c->add('path_log','','text',0,3,NULL,90,TRUE);
    $c->add('path_language','','text',0,3,NULL,100,TRUE);
    $c->add('backup_path','','text',0,3,NULL,110,TRUE);
    $c->add('path_data','','text',0,3,NULL,120,TRUE);
    $c->add('path_images','','text',0,3,NULL,130,TRUE);

    $c->add('fs_pear', NULL, 'fieldset', 0, 4, NULL, 0, TRUE);
    $c->add('have_pear',FALSE,'select',0,4,1,135,TRUE);
    $c->add('path_pear','','text',0,4,NULL,140,TRUE);

    $c->add('fs_mysql', NULL, 'fieldset', 0, 5, NULL, 0, TRUE);
    $c->add('allow_mysqldump',1,'select',0,5,0,170,TRUE);
    $c->add('mysqldump_path','/usr/bin/mysqldump','text',0,5,NULL,175,TRUE);
    $c->add('mysqldump_options','-Q','text',0,5,NULL,180,TRUE);

    $c->add('fs_search', NULL, 'fieldset', 0, 6, NULL, 0, TRUE);
    $c->add('num_search_results',10,'text',0,6,NULL,670,TRUE);

    // Subgroup: Stories and Trackback
    $c->add('sg_stories', NULL, 'subgroup', 1, 0, NULL, 0, TRUE);

    $c->add('fs_story', NULL, 'fieldset', 1, 7, NULL, 0, TRUE);
    $c->add('maximagesperarticle',5,'text',1,7,NULL,1170,TRUE);
    $c->add('limitnews',10,'text',1,7,NULL,1180,TRUE);
    $c->add('minnews',1,'text',1,7,NULL,1190,TRUE);
    $c->add('contributedbyline',1,'select',1,7,0,1200,TRUE);
    $c->add('hideviewscount',0,'select',1,7,0,1210,TRUE);
    $c->add('hideemailicon',0,'select',1,7,0,1220,TRUE);
    $c->add('hideprintericon',0,'select',1,7,0,1230,TRUE);
    $c->add('allow_page_breaks',1,'select',1,7,0,1240,TRUE);
    $c->add('page_break_comments','last','select',1,7,7,1250,TRUE);
    $c->add('article_image_align','right','select',1,7,8,1260,TRUE);
    $c->add('show_topic_icon',1,'select',1,7,0,1270,TRUE);
    $c->add('draft_flag',0,'select',1,7,0,1280,TRUE);
    $c->add('frontpage',1,'select',1,7,0,1290,TRUE);
    $c->add('hide_no_news_msg',0,'select',1,7,0,1300,TRUE);
    $c->add('hide_main_page_navigation',0,'select',1,7,0,1310,TRUE);
    $c->add('onlyrootfeatures',0,'select',1,7,0,1320,TRUE);
    $c->add('aftersave_story','list','select',1,7,9,1330,TRUE);

    $c->add('fs_trackback', NULL, 'fieldset', 1, 8, NULL, 0, TRUE);
    $c->add('trackback_enabled',TRUE,'select',1,8,1,1060,TRUE);
    $c->add('trackback_code',0,'select',1,8,3,1070,TRUE);
    $c->add('trackbackspeedlimit',300,'text',1,8,NULL,1080,TRUE);
    $c->add('check_trackback_link',2,'select',1,8,4,1090,TRUE);
    $c->add('multiple_trackbacks',0,'select',1,8,2,1100,TRUE);

    $c->add('fs_pingback', NULL, 'fieldset', 1, 9, NULL, 0, TRUE);
    $c->add('pingback_enabled',TRUE,'select',1,9,1,1110,TRUE);
    $c->add('pingback_excerpt',TRUE,'select',1,9,1,1120,TRUE);
    $c->add('pingback_self',0,'select',1,9,13,1130,TRUE);
    $c->add('ping_enabled',TRUE,'select',1,9,1,1140,TRUE);

    // Subgroup: Theme
    $c->add('sg_theme', NULL, 'subgroup', 2, 0, NULL, 0, TRUE);

    $c->add('fs_theme', NULL, 'fieldset', 2, 10, NULL, 0, TRUE);
    $c->add('theme','professional','select',2,10,NULL,190,TRUE);
    $c->add('menu_elements',array('contribute','search','stats','directory','plugins'),'%text',2,10,NULL,200,TRUE);
    $c->add('path_themes','','text',2,10,NULL,210,TRUE);

    $c->add('fs_theme_advanced', NULL, 'fieldset', 2, 11, NULL, 0, TRUE);
    $c->add('show_right_blocks',FALSE,'select',2,11,1,1350,TRUE);
    $c->add('showfirstasfeatured',0,'select',2,11,0,1360,TRUE);

    // Subgroup: Blocks
    $c->add('sg_blocks', NULL, 'subgroup', 3, 0, NULL, 0, TRUE);

    $c->add('fs_admin_block', NULL, 'fieldset', 3, 12, NULL, 0, TRUE);
    $c->add('sort_admin',TRUE,'select',3,12,1,340,TRUE);
    $c->add('link_documentation',1,'select',3,12,0,1150,TRUE);
    $c->add('link_versionchecker',1,'select',3,12,0,1160,TRUE);

    $c->add('fs_topics_block', NULL, 'fieldset', 3, 13, NULL, 0, TRUE);
    $c->add('sortmethod','sortnum','select',3,13,15,870,TRUE);
    $c->add('showstorycount',1,'select',3,13,0,880,TRUE);
    $c->add('showsubmissioncount',1,'select',3,13,0,890,TRUE);
    $c->add('hide_home_link',0,'select',3,13,0,900,TRUE);

    $c->add('fs_whosonline_block', NULL, 'fieldset', 3, 14, NULL, 0, TRUE);
    $c->add('whosonline_threshold',300,'text',3,14,NULL,910,TRUE);
    $c->add('whosonline_anonymous',0,'select',3,14,0,920,TRUE);

    $c->add('fs_whatsnew_block', NULL, 'fieldset', 3, 15, NULL, 0, TRUE);
    $c->add('newstoriesinterval',86400,'text',3,15,NULL,980,TRUE);
    $c->add('newcommentsinterval',172800,'text',3,15,NULL,990,TRUE);
    $c->add('newtrackbackinterval',172800,'text',3,15,NULL,1000,TRUE);
    $c->add('hidenewstories',0,'select',3,15,0,1010,TRUE);
    $c->add('hidenewcomments',0,'select',3,15,0,1020,TRUE);
    $c->add('hidenewtrackbacks',0,'select',3,15,0,1030,TRUE);
    $c->add('hidenewplugins',0,'select',3,15,0,1040,TRUE);
    $c->add('title_trim_length',20,'text',3,15,NULL,1050,TRUE);

    // Subgroup: Users and Submissions
    $c->add('sg_users', NULL, 'subgroup', 4, 0, NULL, 0, TRUE);

    $c->add('fs_users', NULL, 'fieldset', 4, 16, NULL, 0, TRUE);
    $c->add('disable_new_user_registration',FALSE,'select',4,16,0,220,TRUE);
    $c->add('allow_user_themes',1,'select',4,16,0,230,TRUE);
    $c->add('allow_user_language',1,'select',4,16,0,240,TRUE);
    $c->add('allow_user_photo',1,'select',4,16,0,250,TRUE);
    $c->add('allow_username_change',0,'select',4,16,0,260,TRUE);
    $c->add('allow_account_delete',0,'select',4,16,0,270,TRUE);
    $c->add('hide_author_exclusion',0,'select',4,16,0,280,TRUE);
    $c->add('show_fullname',0,'select',4,16,0,290,TRUE);
    $c->add('show_servicename',TRUE,'select',4,16,1,300,TRUE);
    $c->add('custom_registration',FALSE,'select',4,16,1,310,TRUE);
    $c->add('user_login_method',array('standard' => true, 'openid' => false, '3rdparty' => false),'@select',4,16,1,320,TRUE);
    $c->add('aftersave_user','item','select',4,16,9,1340,TRUE);

    $c->add('fs_spamx', NULL, 'fieldset', 4, 17, NULL, 0, TRUE);
    $c->add('spamx',128,'text',4,17,NULL,330,TRUE);

    $c->add('fs_login', NULL, 'fieldset', 4, 18, NULL, 0, TRUE);
    $c->add('lastlogin',TRUE,'select',4,18,1,640,TRUE);
    $c->add('loginrequired',0,'select',4,18,0,680,TRUE);
    $c->add('submitloginrequired',0,'select',4,18,0,690,TRUE);
    $c->add('commentsloginrequired',0,'select',4,18,0,700,TRUE);
    $c->add('statsloginrequired',0,'select',4,18,0,710,TRUE);
    $c->add('searchloginrequired',0,'select',4,18,16,720,TRUE);
    $c->add('profileloginrequired',0,'select',4,18,0,730,TRUE);
    $c->add('emailuserloginrequired',0,'select',4,18,0,740,TRUE);
    $c->add('emailstoryloginrequired',0,'select',4,18,0,750,TRUE);
    $c->add('directoryloginrequired',0,'select',4,18,0,760,TRUE);
    $c->add('passwordspeedlimit',300,'text',4,18,NULL,1680,TRUE);
    $c->add('login_attempts',3,'text',4,18,NULL,1690,TRUE);
    $c->add('login_speedlimit',300,'text',4,18,NULL,1700,TRUE);

    $c->add('fs_user_submission', NULL, 'fieldset', 4, 19, NULL, 0, TRUE);
    $c->add('usersubmission',0,'select',4,19,0,780,TRUE);
    $c->add('allow_domains','','text',4,19,NULL,960,TRUE);
    $c->add('disallow_domains','','text',4,19,NULL,970,TRUE);

    $c->add('fs_submission', NULL, 'fieldset', 4, 20, NULL, 0, TRUE);
    $c->add('storysubmission',1,'select',4,20,0,770,TRUE);
    $c->add('listdraftstories',0,'select',4,20,0,790,TRUE);
    $c->add('postmode','plaintext','select',4,20,5,810,TRUE);
    $c->add('speedlimit',45,'text',4,20,NULL,820,TRUE);
    $c->add('skip_preview',0,'select',4,20,0,830,TRUE);
    $c->add('advanced_editor',FALSE,'select',4,20,1,840,TRUE);
    $c->add('wikitext_editor',FALSE,'select',4,20,1,850,TRUE);

    $c->add('fs_comments', NULL, 'fieldset', 4, 21, NULL, 0, TRUE);
    $c->add('commentspeedlimit',45,'text',4,21,NULL,1640,TRUE);
    $c->add('comment_limit',100,'text',4,21,NULL,1650,TRUE);
    $c->add('comment_mode','threaded','select',4,21,11,1660,TRUE);
    $c->add('comment_code',0,'select',4,21,17,1670,TRUE);

    // Subgroup: Images
    $c->add('sg_images', NULL, 'subgroup', 5, 0, NULL, 0, TRUE);

    $c->add('fs_imagelib', NULL, 'fieldset', 5, 22, NULL, 0, TRUE);
    $c->add('image_lib','','select',5,22,10,1450,TRUE);
    $c->add('path_to_mogrify','','text',5,22,NULL,1460,FALSE);
    $c->add('path_to_netpbm','','text',5,22,NULL,1470,FALSE);

    $c->add('fs_upload', NULL, 'fieldset', 5, 23, NULL, 0, TRUE);
    $c->add('keep_unscaled_image',0,'select',5,23,0,1480,TRUE);
    $c->add('allow_user_scaling',1,'select',5,23,0,1490,TRUE);
    $c->add('debug_image_upload',FALSE,'select',5,23,1,1500,TRUE);

    $c->add('fs_articleimg', NULL, 'fieldset', 5, 24, NULL, 0, TRUE);
    $c->add('max_image_width',160,'text',5,24,NULL,1510,TRUE);
    $c->add('max_image_height',160,'text',5,24,NULL,1520,TRUE);
    $c->add('max_image_size',1048576,'text',5,24,NULL,1530,TRUE);

    $c->add('fs_topicicon', NULL, 'fieldset', 5, 25, NULL, 0, TRUE);
    $c->add('max_topicicon_width',48,'text',5,25,NULL,1540,TRUE);
    $c->add('max_topicicon_height',48,'text',5,25,NULL,1550,TRUE);
    $c->add('max_topicicon_size',65536,'text',5,25,NULL,1560,TRUE);

    $c->add('fs_userphoto', NULL, 'fieldset', 5, 26, NULL, 0, TRUE);
    $c->add('max_photo_width',128,'text',5,26,NULL,1570,TRUE);
    $c->add('max_photo_height',128,'text',5,26,NULL,1580,TRUE);
    $c->add('max_photo_size',65536,'text',5,26,NULL,1590,TRUE);
    $c->add('force_photo_width',75,'text',5,26,NULL,1620,FALSE);
    $c->add('default_photo','http://example.com/default.jpg','text',5,26,NULL,1630,FALSE);

    $c->add('fs_gravatar', NULL, 'fieldset', 5, 27, NULL, 0, TRUE);
    $c->add('use_gravatar',FALSE,'select',5,27,1,1600,TRUE);
    $c->add('gravatar_rating','R','text',5,27,NULL,1610,FALSE);

    // Subgroup: Languages and Locale
    $c->add('sg_locale', NULL, 'subgroup', 6, 0, NULL, 0, TRUE);

    $c->add('fs_language', NULL, 'fieldset', 6, 28, NULL, 0, TRUE);
    $c->add('language','english','select',6,28,NULL,350,TRUE);
    $c->add('language_files',array('en'=>'english_utf-8', 'de'=>'german_formal_utf-8'),'*text',6,28,NULL,470,FALSE);
    $c->add('languages',array('en'=>'English', 'de'=>'Deutsch'),'*text',6,28,NULL,480,FALSE);

    $c->add('fs_locale', NULL, 'fieldset', 6, 29, NULL, 0, TRUE);
    $c->add('locale','en_GB','text',6,29,NULL,360,TRUE);
    $c->add('date','%A, %B %d %Y @ %I:%M %p %Z','text',6,29,NULL,370,TRUE);
    $c->add('daytime','%m/%d %I:%M%p','text',6,29,NULL,380,TRUE);
    $c->add('shortdate','%x','text',6,29,NULL,390,TRUE);
    $c->add('dateonly','%d-%b','text',6,29,NULL,400,TRUE);
    $c->add('timeonly','%I:%M%p','text',6,29,NULL,410,TRUE);
    $c->add('week_start','Sun','select',6,29,14,420,TRUE);
    $c->add('hour_mode',12,'select',6,29,6,430,TRUE);
    $c->add('thousand_separator',",",'text',6,29,NULL,440,TRUE);
    $c->add('decimal_separator',".",'text',6,29,NULL,450,TRUE);
    $c->add('decimal_count',"2",'text',6,29,NULL,460,TRUE);
    $c->add('timezone','Etc/GMT-6','text',6,29,NULL,490,FALSE);

    // Subgroup: Miscellaneous
    $c->add('sg_misc', NULL, 'subgroup', 7, 0, NULL, 0, TRUE);

    $c->add('fs_cookies', NULL, 'fieldset', 7, 30, NULL, 0, TRUE);
    $c->add('cookie_session','gl_session','text',7,30,NULL,530,TRUE);
    $c->add('cookie_name','geeklog','text',7,30,NULL,540,TRUE);
    $c->add('cookie_password','password','text',7,30,NULL,550,TRUE);
    $c->add('cookie_theme','theme','text',7,30,NULL,560,TRUE);
    $c->add('cookie_language','language','text',7,30,NULL,570,TRUE);
    $c->add('cookie_tzid','timezone','text',7,30,NULL,575,TRUE);
    $c->add('cookie_ip',0,'select',7,30,0,580,TRUE);
    $c->add('default_perm_cookie_timeout',28800,'text',7,30,NULL,590,TRUE);
    $c->add('session_cookie_timeout',7200,'text',7,30,NULL,600,TRUE);
    $c->add('cookie_path','/','text',7,30,NULL,610,TRUE);
    $c->add('cookiedomain','','text',7,30,NULL,620,TRUE);
    $c->add('cookiesecure',FALSE,'select',7,30,1,630,TRUE);

    $c->add('fs_misc', NULL, 'fieldset', 7, 31, NULL, 0, TRUE);
    $c->add('pdf_enabled',0,'select',7,31,0,660,TRUE);
    $c->add('notification',array(),'%text',7,31,NULL,800,TRUE);
    $c->add('cron_schedule_interval',86400,'text',7,31,NULL,860,TRUE);
    $c->add('disable_autolinks',0,'select',7,31,0,1750,TRUE);

    $c->add('fs_debug', NULL, 'fieldset', 7, 32, NULL, 0, TRUE);
    $c->add('rootdebug',FALSE,'select',7,32,1,520,TRUE);

    $c->add('fs_daily_digest', NULL, 'fieldset', 7, 33, NULL, 0, TRUE);
    $c->add('emailstories',0,'select',7,33,0,930,TRUE);
    $c->add('emailstorieslength',1,'text',7,33,NULL,940,TRUE);
    $c->add('emailstoriesperdefault',0,'select',7,33,0,950,TRUE);

    $c->add('fs_htmlfilter', NULL, 'fieldset', 7, 34, NULL, 0, TRUE);
    $c->add('user_html',array ('p' => array(), 'b' => array(), 'strong' => array(),'i' => array(), 'a' => array('href' => 1, 'title' => 1, 'rel' => 1),'em'     => array(),'br'     => array(),'tt'     => array(),'hr'     => array(),        'li'     => array(), 'ol'     => array(), 'ul'     => array(), 'code' => array(), 'pre'    => array()),'**placeholder',7,34,NULL,1710,TRUE);
    $c->add('admin_html',array ('p' => array('class' => 1, 'id' => 1, 'align' => 1), 'div' => array('class' => 1, 'id' => 1), 'span' => array('class' => 1, 'id' => 1), 'table' => array('class' => 1, 'id' => 1, 'width' => 1, 'border' => 1, 'cellspacing' => 1, 'cellpadding' => 1), 'tr' => array('class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1), 'th' => array('class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1, 'colspan' => 1, 'rowspan' => 1), 'td' => array('class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1, 'colspan' => 1, 'rowspan' => 1)),'**placeholder',7,34,NULL,1720,TRUE);
    $c->add('skip_html_filter_for_root',0,'select',7,34,0,1730,TRUE);
    $c->add('allowed_protocols',array('http','ftp','https'),'%text',7,34,NULL,1740,TRUE);

    $c->add('fs_censoring', NULL, 'fieldset', 7, 35, NULL, 0, TRUE);
    $c->add('censormode',1,'select',7,35,0,1760,TRUE);
    $c->add('censorreplace','*censormode*','text',7,35,NULL,1770,TRUE);
    $c->add('censorlist', array('fuck','cunt','fucker','fucking','pussy','cock','c0ck',' cum ','twat','clit','bitch','fuk','fuking','motherfucker'),'%text',7,35,NULL,1780,TRUE);

    $c->add('fs_iplookup', NULL, 'fieldset', 7, 36, NULL, 0, TRUE);
    $c->add('ip_lookup','/nettools/whois.php?domain=*','text',7,36,NULL,1790,FALSE);

    $c->add('fs_perm_story', NULL, 'fieldset', 7, 37, NULL, 0, TRUE);
    $c->add('default_permissions_story',array(3, 2, 2, 2),'@select',7,37,12,1820,TRUE);

    $c->add('fs_perm_topic', NULL, 'fieldset', 7, 38, NULL, 0, TRUE);
    $c->add('default_permissions_topic',array(3, 2, 2, 2),'@select',7,38,12,1830,TRUE);

    $c->add('fs_perm_block', NULL, 'fieldset', 7, 39, NULL, 0, TRUE);
    $c->add('default_permissions_block',array(3, 2, 2, 2),'@select',7,39,12,1810,TRUE);

    $c->add('fs_webservices', NULL, 'fieldset', 7, 40, NULL, 0, TRUE);
    $c->add('disable_webservices',   0, 'select', 7, 40, 0, 1840, TRUE);
    $c->add('restrict_webservices',  0, 'select', 7, 40, 0, 1850, TRUE);
    $c->add('atom_max_stories',     10, 'text',   7, 40, 0, 1860, TRUE);
}

// Polls plugin updates
function upgrade_PollsPlugin()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $plugin_path = $_CONF['path'] . 'plugins/polls/';
    require_once $plugin_path . 'install_defaults.php';

    if (file_exists($plugin_path . 'config.php')) {
        global $_DB_table_prefix, $_PO_CONF;

        require_once $plugin_path . 'config.php';
    }

    if (!plugin_initconfig_polls()) {
        echo 'There was an error upgrading the Polls plugin';
        return false;
    }

    $P_SQL = array();
    //$P_SQL[] = "ALTER TABLE {$_TABLES['polltopics']} RENAME TO {$_TABLES['pollquestions']};";
    $P_SQL[] = "ALTER TABLE {$_TABLES['pollquestions']} DROP CONSTRAINT [PK_gl_pollquestions];";
    $P_SQL[] = "EXEC sp_rename '{$_TABLES['pollquestions']}', '{$_TABLES['polltopics']}'";
    $P_SQL[] = "EXEC sp_rename '{$_TABLES['polltopics']}.question', 'topic', 'COLUMN'";
    $P_SQL[] = "ALTER TABLE {$_TABLES['polltopics']} ALTER COLUMN [topic] VARCHAR( 255 ) NULL";
    $P_SQL[] = "EXEC sp_rename '{$_TABLES['polltopics']}.qid', 'pid', 'COLUMN'";
    $P_SQL[] = "ALTER TABLE {$_TABLES['polltopics']} ADD questions int default '0' NOT NULL";
    $P_SQL[] = "ALTER TABLE {$_TABLES['polltopics']} ADD is_open tinyint NOT NULL default '1'";
    $P_SQL[] = "ALTER TABLE {$_TABLES['polltopics']} ADD hideresults tinyint NOT NULL default '0'";
    $P_SQL[] = "EXEC sp_rename '{$_TABLES['pollanswers']}.qid', 'pid', 'COLUMN'";
    $P_SQL[] = "ALTER TABLE {$_TABLES['pollanswers']} ADD qid VARCHAR(20) NOT NULL default '0'";
    $P_SQL[] = "ALTER TABLE {$_TABLES['pollanswers']} DROP CONSTRAINT [PK_gl_pollanswers];";
    $P_SQL[] = "ALTER TABLE {$_TABLES['pollanswers']} ADD CONSTRAINT [PK_{$_TABLES['pollanswers']}] PRIMARY KEY CLUSTERED ([pid], [qid], [aid]) ON [PRIMARY];";
    $P_SQL[] = "EXEC sp_rename '{$_TABLES['pollvoters']}.qid', 'pid', 'COLUMN'";
    $P_SQL[] = "ALTER TABLE {$_TABLES['pollvoters']} ALTER COLUMN [pid] VARCHAR( 20 ) NOT NULL";
    $P_SQL[] = "CREATE TABLE [dbo].[{$_TABLES['pollquestions']}] (
        [qid] [int] NOT NULL DEFAULT 0,
        [pid] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
        [question] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
        CONSTRAINT [PK_{$_TABLES['pollquestions']}] PRIMARY KEY  CLUSTERED 
	    (
		    [qid]
	    )  ON [PRIMARY] 
    ) ON [PRIMARY]";
    // in 1.4.1, "don't display poll" was equivalent to "closed"
    $P_SQL[] = "UPDATE {$_TABLES['polltopics']} SET is_open = 0 WHERE display = 0";
    $P_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version = '2.0.1', pi_gl_version = '1.5.0' WHERE pi_name = 'polls'";

    foreach ($P_SQL as $sql) {
        $rst = DB_query($sql);
        if (DB_error()) {
            echo "There was an error upgrading the polls, SQL: $sql<br>";
            return false;
        }
    }
    $P_SQL = array();

    $move_sql = "SELECT pid, topic FROM {$_TABLES['polltopics']}";
    $move_rst = DB_query ($move_sql);
    $count_move = DB_numRows($move_rst);
    for ($i = 0; $i < $count_move; $i++) {
        $A = DB_fetchArray($move_rst);
        $A[1] = str_replace("'", "''", $A[1]);
        $P_SQL[] = "INSERT INTO {$_TABLES['pollquestions']} (pid, question) VALUES ('{$A[0]}','{$A[1]}');";
    }

    foreach ($P_SQL as $sql) {
        $rst = DB_query($sql);
        if (DB_error()) {
            echo "There was an error upgrading the polls, SQL: $sql<br>";
            return false;
        }
    }

    return true;
}

// Staticpages plugin updates
function upgrade_StaticpagesPlugin()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $plugin_path = $_CONF['path'] . 'plugins/staticpages/';
    require_once $plugin_path . 'install_defaults.php';

    if (file_exists($plugin_path . 'config.php')) {
        global $_DB_table_prefix, $_SP_CONF;

        require_once $plugin_path . 'config.php';
    }

    if (!plugin_initconfig_staticpages()) {
        echo 'There was an error upgrading the Static Pages plugin';
        return false;
    }

    $P_SQL = array();
    $P_SQL[] = "ALTER TABLE {$_TABLES['staticpage']} ADD [commentcode] TINYINT NOT NULL default '0'";
    // disable comments on all existing static pages
    $P_SQL[] = "UPDATE {$_TABLES['staticpage']} SET commentcode = 0";
    $P_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version = '1.5.0', pi_gl_version = '1.5.0' WHERE pi_name = 'staticpages'";

    foreach ($P_SQL as $sql) {
        $rst = DB_query($sql);
        if (DB_error()) {
            echo "There was an error upgrading the Static Pages plugin, SQL: $sql<br>";
            return false;
        }
    }

    return true;
}

// Calendar plugin updates
function upgrade_CalendarPlugin()
{
    global $_CONF, $_TABLES, $_STATES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $plugin_path = $_CONF['path'] . 'plugins/calendar/';
    require_once $plugin_path . 'install_defaults.php';

    if (file_exists($plugin_path . 'config.php')) {
        global $_DB_table_prefix, $_CA_CONF;

        require_once $plugin_path . 'config.php';
    }

    if (!plugin_initconfig_calendar()) {
        echo 'There was an error upgrading the Polls plugin';
        return false;
    }

    $P_SQL[] = "ALTER TABLE {$_TABLES['events']} ALTER COLUMN [state] varchar(40)";
    $P_SQL[] = "ALTER TABLE {$_TABLES['eventsubmission']} ALTER COLUMN [state] varchar(40)";
    $P_SQL[] = "ALTER TABLE {$_TABLES['personal_events']} ALTER COLUMN [state] varchar(40)";
    $P_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version = '1.0.2', pi_gl_version = '1.5.0' WHERE pi_name = 'calendar'";

    foreach ($P_SQL as $sql) {
        $rst = DB_query($sql);
        if (DB_error()) {
            echo "There was an error upgrading the calendar";
            return false;
        }
    }

    if (isset($_STATES) && is_array($_STATES)) {
        $tables = array($_TABLES['events'], $_TABLES['eventsubmission'],
                        $_TABLES['personal_events']);

        foreach ($_STATES as $key => $state) {
            foreach ($tables as $table) {
                DB_change($table, 'state', addslashes($state),
                                  'state', addslashes($key));
            }
        }
    }

    return true;
}

// Spam-X plugin updates
function upgrade_SpamXPlugin()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $plugin_path = $_CONF['path'] . 'plugins/spamx/';
    require_once $plugin_path . 'install_defaults.php';

    if (file_exists($plugin_path . 'config.php')) {
        global $_DB_table_prefix, $_SPX_CONF;

        require_once $plugin_path . 'config.php';
    }

    if (!plugin_initconfig_spamx()) {
        echo 'There was an error upgrading the Spam-X plugin';
        return false;
    }

    $sql = "UPDATE {$_TABLES['plugins']} SET pi_version = '1.1.1', pi_gl_version = '1.5.0' WHERE pi_name = 'spamx'";
    $rst = DB_query($sql);
    if (DB_error()) {
        echo "There was an error upgrading the Spam-X plugin";
        return false;
    }

    return true;
}

// Links plugin updates
function upgrade_LinksPlugin()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $plugin_path = $_CONF['path'] . 'plugins/links/';
    require_once $plugin_path . 'install_defaults.php';

    if (file_exists($plugin_path . 'config.php')) {
        global $_DB_table_prefix, $_LI_CONF;

        require_once $plugin_path . 'config.php';
    }

    if (!plugin_initconfig_links()) {
        echo 'There was an error upgrading the Links plugin';
        return false;
    }

    $li_config = config::get_instance();
    $_LI_CONF = $li_config->get_config('links');

    if (empty($_LI_CONF['root'])) {
        $_LI_CONF['root'] = 'site';
    }
    $root = addslashes($_LI_CONF['root']);

    $P_SQL = array();
    $P_SQL[] = "CREATE TABLE [dbo].[{$_TABLES['linkcategories']}] (
        [cid] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
        [pid] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
        [category] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
        [description] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
        [tid] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
        [created] [datetime] NULL ,
        [modified] [datetime] NULL ,
        [owner_id] [numeric](8, 0) NOT NULL ,
        [group_id] [numeric](8, 0) NOT NULL ,
        [perm_owner] [tinyint] NOT NULL ,
        [perm_group] [tinyint] NOT NULL ,
        [perm_members] [tinyint] NOT NULL ,
        [perm_anon] [tinyint] NOT NULL
    ) ON [PRIMARY]";
    $P_SQL[] = "ALTER TABLE [dbo].[{$_TABLES['linkcategories']}] ADD
        CONSTRAINT [PK_{$_TABLES['linkcategories']}] PRIMARY KEY  CLUSTERED
        (
            [pid]
        )  ON [PRIMARY]";

    $blockadmin_id = DB_getItem($_TABLES['groups'], 'grp_id',
                                "grp_name='Block Admin'");

    $P_SQL[] = "ALTER TABLE {$_TABLES['linksubmission']} ADD owner_id INTEGER NOT NULL default '1'";
    $P_SQL[] = "EXEC sp_rename '{$_TABLES['linksubmission']}.category', 'cid', 'COLUMN'";
    $P_SQL[] = "ALTER TABLE {$_TABLES['linksubmission']} ALTER COLUMN [cid] varchar(32) NOT NULL";
    $P_SQL[] = "EXEC sp_rename '{$_TABLES['links']}.category', 'cid', 'COLUMN'";
    $P_SQL[] = "ALTER TABLE {$_TABLES['links']} ALTER COLUMN [cid] varchar(32) NOT NULL";
    $P_SQL[] = "INSERT INTO {$_TABLES['linkcategories']} (cid, pid, category, description, tid, created, modified, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('{$root}', 'root', 'Root', 'Website root', NULL, NOW(), NOW(), 5, 2, 3, 3, 2, 2)";
    $P_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version = '2.0.0', pi_gl_version='1.5.0' WHERE pi_name='links'";

    foreach ($P_SQL as $sql) {
        $rst = DB_query($sql);
        if (DB_error()) {
            echo "There was an error upgrading the links, SQL: $sql<br>";
            return false;
        }
    }

    // get Links admin group number
    $group_id = DB_getItem($_TABLES['groups'], 'grp_id',
                           "grp_name = 'Links Admin'");

    // loop through adding to category table, then update links table with cids
    $result = DB_query("SELECT DISTINCT cid AS category FROM {$_TABLES['links']}");
    $nrows = DB_numRows($result);
    for ($i = 0; $i < $nrows; $i++) {

        $A = DB_fetchArray($result);
        $category = addslashes($A['category']);
        $cid = $category;
        $sql = "INSERT INTO {$_TABLES['linkcategories']} (cid,pid,category,description,tid,owner_id,group_id,created,modified, perm_owner, perm_group, perm_members, perm_anon) VALUES ('{$cid}','{$root}','{$category}','{$category}','all',2,'{$group_id}',NOW(),NOW(), 3, 3, 2, 2)";
        DB_query($sql,0);
        if ($cid != $category) { // still experimenting ...
            $sql = "UPDATE {$_TABLES['links']} SET cid='{$cid}' WHERE cid='{$category}'";
            DB_query($sql,0);
        }
        if (DB_error()) {
            echo "Error inserting categories into linkcategories table";
            return false;
        }
    }

    return true;
}

// add the new 'webservices.atompub' feature and the 'Webservices Users' group
function upgrade_addWebservicesFeature()
{
    global $_TABLES;

    $ft_id = DB_getItem($_TABLES['features'], 'ft_id',
                        "ft_name = 'webservices.atompub'");
    $grp_id = DB_getItem($_TABLES['groups'], 'grp_id',
                          "grp_name = 'Webservices Users'");
    $rootgrp = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");

    if (($grp_id > 0) && ($ft_id > 0)) {
        // add 'webservices.atompub' feature to 'Webservices Users' group
        DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($ft_id, $grp_id)");

        // make 'Root' members a member of 'Webservices Users'
        if ($rootgrp > 0) {
            DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES ($grp_id, NULL, $rootgrp)");
        }
    }
}

?>
