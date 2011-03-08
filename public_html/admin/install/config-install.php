<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | config-install.php                                                        |
// |                                                                           |
// | Initial configuration setup.                                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Aaron Blankstein  - kantai AT gmail DOT com                      |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

if (strpos(strtolower($_SERVER['PHP_SELF']), 'config-install.php') !== false) {
    die('This file can not be used on its own!');
}

function install_config()
{
    global $_CONF, $_TABLES;

    $me = 'Core';
    
    $c = config::get_instance();

    // Subgroup: Site
    $c->add('sg_site', NULL, 'subgroup', 0, 0, NULL, 0, TRUE, $me, 0);

    $c->add('tab_site', NULL, 'tab', 0, 0, NULL, 0, TRUE, $me, 0);
    $c->add('fs_site', NULL, 'fieldset', 0, 0, NULL, 0, TRUE, $me, 0);
    $c->add('site_url','','text',0,0,NULL,20,TRUE, $me, 0);
    $c->add('site_admin_url','','text',0,0,NULL,30,TRUE, $me, 0);
    $c->add('site_name','','text',0,0,NULL,60,TRUE, $me, 0);
    $c->add('site_slogan','','text',0,0,NULL,70,TRUE, $me, 0);
    $c->add('microsummary_short','GL: ','text',0,0,NULL,80,TRUE, $me, 0);
    $c->add('site_disabled_msg','Geeklog Site is down. Please come back soon.','textarea',0,0,NULL,510,TRUE, $me, 0);
    $c->add('owner_name','','text',0,0,NULL,1000,TRUE, $me, 0);
    $c->add('copyrightyear',date('Y'),'text',0,0,NULL,1440,FALSE, $me, 0);
    $c->add('url_rewrite',FALSE,'select',0,0,1,1800,TRUE, $me, 0);
    $c->add('cdn_hosted',FALSE,'select',0,0,1,1900,TRUE, $me, 0);
    $c->add('meta_tags',0,'select',0,0,23,2000,TRUE, $me, 0);
    $c->add('meta_description','Geeklog - The secure Content Management System.','textarea',0,0,NULL,2010,TRUE, $me, 0);
    $c->add('meta_keywords','Geeklog, Content Management System, CMS, Open Source, Secure, Security, Blog, Weblog','textarea',0,0,NULL,2020,TRUE, $me, 0);

    $c->add('tab_mail', NULL, 'tab', 0, 1, NULL, 0, TRUE, $me, 1);
    $c->add('fs_mail', NULL, 'fieldset', 0, 1, NULL, 0, TRUE, $me, 1);
    $c->add('site_mail','','text',0,1,NULL,40,TRUE, $me, 1);
    $c->add('noreply_mail','','text',0,1,NULL,50,TRUE, $me, 1);
    $c->add('mail_settings',array ('backend' => 'mail', 'sendmail_path' => '/usr/bin/sendmail', 'sendmail_args' => '', 'host' => 'smtp.example.com','port' => '25', 'auth' => false, 'username' => 'smtp-username','password' => 'smtp-password'),'@text',0,1,NULL,160,TRUE, $me, 1);

    $c->add('tab_syndication', NULL, 'tab', 0, 2, NULL, 0, TRUE, $me, 2);
    $c->add('fs_syndication', NULL, 'fieldset', 0, 2, NULL, 0, TRUE, $me, 2);
    $c->add('backend',1,'select',0,2,0,1380,TRUE, $me, 2);
    $c->add('rdf_file','','text',0,2,NULL,1390,TRUE, $me, 2);
    $c->add('rdf_limit',10,'text',0,2,NULL,1400,TRUE, $me, 2);
    $c->add('rdf_storytext',1,'text',0,2,NULL,1410,TRUE, $me, 2);
    $c->add('rdf_language','en-gb','text',0,2,NULL,1420,TRUE, $me, 2);
    $c->add('syndication_max_headlines',0,'text',0,2,NULL,1430,TRUE, $me, 2);

    $c->add('tab_paths', NULL, 'tab', 0, 3, NULL, 0, TRUE, $me, 3);
    $c->add('fs_paths', NULL, 'fieldset', 0, 3, NULL, 0, TRUE, $me, 3);
    $c->add('path_html','','text',0,3,NULL,10,TRUE, $me, 3);
    $c->add('path_log','','text',0,3,NULL,90,TRUE, $me, 3);
    $c->add('path_language','','text',0,3,NULL,100,TRUE, $me, 3);
    $c->add('backup_path','','text',0,3,NULL,110,TRUE, $me, 3);
    $c->add('path_data','','text',0,3,NULL,120,TRUE, $me, 3);
    $c->add('path_images','','text',0,3,NULL,130,TRUE, $me, 3);

    $c->add('tab_pear', NULL, 'tab', 0, 4, NULL, 0, TRUE, $me, 4);
    $c->add('fs_pear', NULL, 'fieldset', 0, 4, NULL, 0, TRUE, $me, 4);
    $c->add('have_pear',FALSE,'select',0,4,1,135,TRUE, $me, 4);
    $c->add('path_pear','','text',0,4,NULL,140,TRUE, $me, 4);

    $c->add('tab_mysql', NULL, 'tab', 0, 5, NULL, 0, TRUE, $me, 5);
    $c->add('fs_mysql', NULL, 'fieldset', 0, 5, NULL, 0, TRUE, $me, 5);
    $c->add('allow_mysqldump',1,'select',0,5,0,170,TRUE, $me, 5);
    $c->add('mysqldump_path','/usr/bin/mysqldump','text',0,5,NULL,175,TRUE, $me, 5);
    $c->add('mysqldump_options','-Q','text',0,5,NULL,180,TRUE, $me, 5);
    $c->add('mysqldump_filename_mask','geeklog_db_backup_%Y_%m_%d_%H_%M_%S.sql','text',0,5,NULL,185,TRUE, $me, 5);

    // squeeze search options between 640 (lastlogin) and 680 (loginrequired)
    $c->add('tab_search', NULL, 'tab', 0, 6, NULL, 0, TRUE, $me, 6);
    $c->add('fs_search', NULL, 'fieldset', 0, 6, NULL, 0, TRUE, $me, 6);
    $c->add('search_style','google','select',0,6,19,644,TRUE, $me, 6);
    $c->add('search_limits','10,15,25,30','text',0,6,NULL,647,TRUE, $me, 6);
    $c->add('num_search_results',30,'text',0,6,NULL,651,TRUE, $me, 6);
    $c->add('search_show_limit',TRUE,'select',0,6,1,654,TRUE, $me, 6);
    $c->add('search_show_sort',TRUE,'select',0,6,1,658,TRUE, $me, 6);
    $c->add('search_show_num',TRUE,'select',0,6,1,661,TRUE, $me, 6);
    $c->add('search_show_type',TRUE,'select',0,6,1,665,TRUE, $me, 6);
    $c->add('search_separator',' &gt; ','text',0,6,NULL,668,TRUE, $me, 6);
    $c->add('search_def_keytype','phrase','select',0,6,20,672,TRUE, $me, 6);
    $c->add('search_use_fulltext', FALSE, 'hidden', 0, 6, NULL, 0, TRUE, $me, 6); // 675
    $c->add('search_def_sort','hits|desc','select',0,6,27,676,TRUE, $me, 6);

    // Subgroup: Stories and Trackback
    $c->add('sg_stories', NULL, 'subgroup', 1, 0, NULL, 0, TRUE, $me, 0);

    $c->add('tab_story', NULL, 'tab', 1, 7, NULL, 0, TRUE, $me, 7);
    $c->add('fs_story', NULL, 'fieldset', 1, 7, NULL, 0, TRUE, $me, 7);
    $c->add('maximagesperarticle',5,'text',1,7,NULL,1170,TRUE, $me, 7);
    $c->add('limitnews',10,'text',1,7,NULL,1180,TRUE, $me, 7);
    $c->add('minnews',1,'text',1,7,NULL,1190,TRUE, $me, 7);
    $c->add('contributedbyline',1,'select',1,7,0,1200,TRUE, $me, 7);
    $c->add('hideviewscount',0,'select',1,7,0,1210,TRUE, $me, 7);
    $c->add('hideemailicon',0,'select',1,7,0,1220,TRUE, $me, 7);
    $c->add('hideprintericon',0,'select',1,7,0,1230,TRUE, $me, 7);
    $c->add('allow_page_breaks',1,'select',1,7,0,1240,TRUE, $me, 7);
    $c->add('page_break_comments','last','select',1,7,7,1250,TRUE, $me, 7);
    $c->add('article_image_align','right','select',1,7,8,1260,TRUE, $me, 7);
    $c->add('show_topic_icon',1,'select',1,7,0,1270,TRUE, $me, 7);
    $c->add('draft_flag',0,'select',1,7,0,1280,TRUE, $me, 7);
    $c->add('frontpage',1,'select',1,7,0,1290,TRUE, $me, 7);
    $c->add('hide_no_news_msg',0,'select',1,7,0,1300,TRUE, $me, 7);
    $c->add('hide_main_page_navigation',0,'select',1,7,0,1310,TRUE, $me, 7);
    $c->add('onlyrootfeatures',0,'select',1,7,0,1320,TRUE, $me, 7);
    $c->add('aftersave_story','list','select',1,7,9,1330,TRUE, $me, 7);

    $c->add('tab_trackback', NULL, 'tab', 1, 8, NULL, 0, TRUE, $me, 8);
    $c->add('fs_trackback', NULL, 'fieldset', 1, 8, NULL, 0, TRUE, $me, 8);
    $c->add('trackback_enabled',TRUE,'select',1,8,1,1060,TRUE, $me, 8);
    $c->add('trackback_code',0,'select',1,8,3,1070,TRUE, $me, 8);
    $c->add('trackbackspeedlimit',300,'text',1,8,NULL,1080,TRUE, $me, 8);
    $c->add('check_trackback_link',2,'select',1,8,4,1090,TRUE, $me, 8);
    $c->add('multiple_trackbacks',0,'select',1,8,2,1100,TRUE, $me, 8);

    $c->add('tab_pingback', NULL, 'tab', 1, 9, NULL, 0, TRUE, $me, 9);
    $c->add('fs_pingback', NULL, 'fieldset', 1, 9, NULL, 0, TRUE, $me, 9);
    $c->add('pingback_enabled',TRUE,'select',1,9,1,1110,TRUE, $me, 9);
    $c->add('pingback_excerpt',TRUE,'select',1,9,1,1120,TRUE, $me, 9);
    $c->add('pingback_self',0,'select',1,9,13,1130,TRUE, $me, 9);
    $c->add('ping_enabled',TRUE,'select',1,9,1,1140,TRUE, $me, 9);

    // Subgroup: Theme
    $c->add('sg_theme', NULL, 'subgroup', 2, 0, NULL, 0, TRUE, $me, 0);
    
    $c->add('tab_theme', NULL, 'tab', 2, 10, NULL, 0, TRUE, $me, 10);
    $c->add('fs_theme', NULL, 'fieldset', 2, 10, NULL, 0, TRUE, $me, 10);
    $c->add('theme','professional','select',2,10,NULL,190,TRUE, $me, 10);
    $c->add('doctype','html401strict','select',2,10,21,195,TRUE, $me, 10);
    $c->add('menu_elements',array('contribute','search','stats','directory','plugins'),'%select',2,10,24,200,TRUE, $me, 10);
    $c->add('path_themes','','text',2,10,NULL,210,TRUE, $me, 10);

    $c->add('tab_theme_advanced', NULL, 'tab', 2, 11, NULL, 0, TRUE, $me, 11);
    $c->add('fs_theme_advanced', NULL, 'fieldset', 2, 11, NULL, 0, TRUE, $me, 11);
    $c->add('show_right_blocks',FALSE,'select',2,11,1,1350,TRUE, $me, 11);
    $c->add('showfirstasfeatured',0,'select',2,11,0,1360,TRUE, $me, 11);

    // Subgroup: Blocks
    $c->add('sg_blocks', NULL, 'subgroup', 3, 0, NULL, 0, TRUE, $me, 0);
    
    $c->add('tab_admin_block', NULL, 'tab', 3, 12, NULL, 0, TRUE, $me, 12);
    $c->add('fs_admin_block', NULL, 'fieldset', 3, 12, NULL, 0, TRUE, $me, 12);
    $c->add('sort_admin',TRUE,'select',3,12,1,340,TRUE, $me, 12);
    $c->add('link_documentation',1,'select',3,12,0,1150,TRUE, $me, 12);
    $c->add('link_versionchecker',1,'select',3,12,0,1160,TRUE, $me, 12);

    $c->add('tab_topics_block', NULL, 'tab', 3, 13, NULL, 0, TRUE, $me, 13);
    $c->add('fs_topics_block', NULL, 'fieldset', 3, 13, NULL, 0, TRUE, $me, 13);
    $c->add('sortmethod','alpha','select',3,13,15,870,TRUE, $me, 13);
    $c->add('showstorycount',1,'select',3,13,0,880,TRUE, $me, 13);
    $c->add('showsubmissioncount',1,'select',3,13,0,890,TRUE, $me, 13);
    $c->add('hide_home_link',0,'select',3,13,0,900,TRUE, $me, 13);

    $c->add('tab_whosonline_block', NULL, 'tab', 3, 14, NULL, 0, TRUE, $me, 14);
    $c->add('fs_whosonline_block', NULL, 'fieldset', 3, 14, NULL, 0, TRUE, $me, 14);
    $c->add('whosonline_threshold',300,'text',3,14,NULL,910,TRUE, $me, 14);
    $c->add('whosonline_anonymous',0,'select',3,14,0,920,TRUE, $me, 14);
    $c->add('whosonline_photo',0,'select',3,14,0,930,TRUE, $me, 14);

    $c->add('tab_whatsnew_block', NULL, 'tab', 3, 15, NULL, 0, TRUE, $me, 15);
    $c->add('fs_whatsnew_block', NULL, 'fieldset', 3, 15, NULL, 0, TRUE, $me, 15);
    $c->add('newstoriesinterval',86400,'text',3,15,NULL,980,TRUE, $me, 15);
    $c->add('newcommentsinterval',172800,'text',3,15,NULL,990,TRUE, $me, 15);
    $c->add('newtrackbackinterval',172800,'text',3,15,NULL,1000,TRUE, $me, 15);
    $c->add('hidenewstories',0,'select',3,15,0,1010,TRUE, $me, 15);
    $c->add('hidenewcomments',0,'select',3,15,0,1020,TRUE, $me, 15);
    $c->add('hidenewtrackbacks',0,'select',3,15,0,1030,TRUE, $me, 15);
    $c->add('hidenewplugins',0,'select',3,15,0,1040,TRUE, $me, 15);
    $c->add('title_trim_length',20,'text',3,15,NULL,1050,TRUE, $me, 15);

    // Subgroup: Users and Submissions
    $c->add('sg_users', NULL, 'subgroup', 4, 0, NULL, 0, TRUE);

    $c->add('tab_users', NULL, 'tab', 4, 16, NULL, 0, TRUE, $me, 16);
    $c->add('fs_users', NULL, 'fieldset', 4, 16, NULL, 0, TRUE, $me, 16);
    $c->add('disable_new_user_registration',FALSE,'select',4,16,0,220,TRUE, $me, 16);
    $c->add('allow_user_themes',1,'select',4,16,0,230,TRUE, $me, 16);
    $c->add('allow_user_language',1,'select',4,16,0,240,TRUE, $me, 16);
    $c->add('allow_user_photo',1,'select',4,16,0,250,TRUE, $me, 16);
    $c->add('allow_username_change',0,'select',4,16,0,260,TRUE, $me, 16);
    $c->add('allow_account_delete',0,'select',4,16,0,270,TRUE, $me, 16);
    $c->add('hide_author_exclusion',0,'select',4,16,0,280,TRUE, $me, 16);
    $c->add('show_fullname',0,'select',4,16,0,290,TRUE, $me, 16);
    $c->add('show_servicename',TRUE,'select',4,16,1,300,TRUE, $me, 16);
    $c->add('custom_registration',FALSE,'select',4,16,1,310,TRUE, $me, 16);
    $c->add('user_login_method',array('standard' => true, 'openid' => false, '3rdparty' => false, 'oauth' => false),'@select',4,16,1,320,TRUE, $me, 16);
    $c->add('facebook_login',0,'select',4,16,1,350,TRUE, $me, 16);
    $c->add('facebook_consumer_key','','text',4,16,NULL,351,TRUE, $me, 16);
    $c->add('facebook_consumer_secret','','text',4,16,NULL,352,TRUE, $me, 16);
    $c->add('linkedin_login',0,'select',4,16,1,353,TRUE, $me, 16);
    $c->add('linkedin_consumer_key','','text',4,16,NULL,354,TRUE, $me, 16);
    $c->add('linkedin_consumer_secret','','text',4,16,NULL,355,TRUE, $me, 16);
    $c->add('twitter_login',0,'select',4,16,1,356,TRUE, $me, 16);
    $c->add('twitter_consumer_key','','text',4,16,NULL,357,TRUE, $me, 16);
    $c->add('twitter_consumer_secret','','text',4,16,NULL,358,TRUE, $me, 16);
    $c->add('aftersave_user','item','select',4,16,9,1340,TRUE, $me, 16);
    
    $c->add('tab_spamx', NULL, 'tab', 4, 17, NULL, 0, TRUE, $me, 17);
    $c->add('fs_spamx', NULL, 'fieldset', 4, 17, NULL, 0, TRUE, $me, 17);
    $c->add('spamx',128,'text',4,17,NULL,330,TRUE, $me, 17);

    $c->add('tab_login', NULL, 'tab', 4, 18, NULL, 0, TRUE, $me, 18);
    $c->add('fs_login', NULL, 'fieldset', 4, 18, NULL, 0, TRUE, $me, 18);
    $c->add('lastlogin',TRUE,'select',4,18,1,640,TRUE, $me, 18);
    $c->add('loginrequired',0,'select',4,18,0,680,TRUE, $me, 18);
    $c->add('submitloginrequired',0,'select',4,18,0,690,TRUE, $me, 18);
    $c->add('commentsloginrequired',0,'select',4,18,0,700,TRUE, $me, 18);
    $c->add('statsloginrequired',0,'select',4,18,0,710,TRUE, $me, 18);
    $c->add('searchloginrequired',0,'select',4,18,16,720,TRUE, $me, 18);
    $c->add('profileloginrequired',0,'select',4,18,0,730,TRUE, $me, 18);
    $c->add('emailuserloginrequired',0,'select',4,18,0,740,TRUE, $me, 18);
    $c->add('emailstoryloginrequired',0,'select',4,18,0,750,TRUE, $me, 18);
    $c->add('directoryloginrequired',0,'select',4,18,0,760,TRUE, $me, 18);
    $c->add('passwordspeedlimit',300,'text',4,18,NULL,1680,TRUE, $me, 18);
    $c->add('login_attempts',3,'text',4,18,NULL,1690,TRUE, $me, 18);
    $c->add('login_speedlimit',300,'text',4,18,NULL,1700,TRUE, $me, 18);

    $c->add('tab_user_submission', NULL, 'tab', 4, 19, NULL, 0, TRUE, $me, 19);
    $c->add('fs_user_submission', NULL, 'fieldset', 4, 19, NULL, 0, TRUE, $me, 19);
    $c->add('usersubmission',0,'select',4,19,0,780,TRUE, $me, 19);
    $c->add('allow_domains','','text',4,19,NULL,960,TRUE, $me, 19);
    $c->add('disallow_domains','','text',4,19,NULL,970,TRUE, $me, 19);

    $c->add('tab_submission', NULL, 'tab', 4, 20, NULL, 0, TRUE, $me, 20);
    $c->add('fs_submission', NULL, 'fieldset', 4, 20, NULL, 0, TRUE, $me, 20);
    $c->add('storysubmission',1,'select',4,20,0,770,TRUE, $me, 20);
    $c->add('listdraftstories',0,'select',4,20,0,790,TRUE, $me, 20);
    $c->add('postmode','plaintext','select',4,20,5,810,TRUE, $me, 20);
    $c->add('speedlimit',45,'text',4,20,NULL,820,TRUE, $me, 20);
    $c->add('skip_preview',0,'select',4,20,0,830,TRUE, $me, 20);
    $c->add('advanced_editor',FALSE,'select',4,20,1,840,TRUE, $me, 20);
    $c->add('wikitext_editor',FALSE,'select',4,20,1,850,TRUE, $me, 20);

    $c->add('tab_comments', NULL, 'tab', 4, 21, NULL, 0, TRUE, $me, 21);
    $c->add('fs_comments', NULL, 'fieldset', 4, 21, NULL, 0, TRUE, $me, 21);
    $c->add('commentspeedlimit',45,'text',4,21,NULL,1640,TRUE, $me, 21);
    $c->add('comment_limit',100,'text',4,21,NULL,1650,TRUE, $me, 21);
    $c->add('comment_mode','nested','select',4,21,11,1660,TRUE, $me, 21);
    $c->add('comment_code',0,'select',4,21,17,1670,TRUE, $me, 21);
    $c->add('comment_edit',0,'select',4,21,0,1680,TRUE, $me, 21);
    $c->add('commentsubmission',0,'select',4,21,0, 1682, TRUE, $me, 21);
    $c->add('comment_edittime',1800,'text',4,21,NULL,1684,TRUE, $me, 21);
    $c->add('article_comment_close_enabled',0,'select',4,21,0, 1685, TRUE, $me, 21);
    $c->add('article_comment_close_days',30,'text',4,21,NULL,1686,TRUE, $me, 21);
    $c->add('comment_close_rec_stories',0,'text',4,21,NULL,1688,TRUE, $me, 21);
    $c->add('allow_reply_notifications',0,'select',4,21,0, 1689, TRUE, $me, 21);

    // Subgroup: Images
    $c->add('sg_images', NULL, 'subgroup', 5, 0, NULL, 0, TRUE, $me, 0);

    $c->add('tab_imagelib', NULL, 'tab', 5, 22, NULL, 0, TRUE, $me, 22);
    $c->add('fs_imagelib', NULL, 'fieldset', 5, 22, NULL, 0, TRUE, $me, 22);
    $c->add('image_lib','','select',5,22,10,1450,TRUE, $me, 22);
    $c->add('path_to_mogrify','','text',5,22,NULL,1460,FALSE, $me, 22);
    $c->add('path_to_netpbm','','text',5,22,NULL,1470,FALSE, $me, 22);

    $c->add('tab_upload', NULL, 'tab', 5, 23, NULL, 0, TRUE, $me, 23);
    $c->add('fs_upload', NULL, 'fieldset', 5, 23, NULL, 0, TRUE, $me, 23);
    $c->add('keep_unscaled_image',0,'select',5,23,0,1480,TRUE, $me, 23);
    $c->add('allow_user_scaling',1,'select',5,23,0,1490,TRUE, $me, 23);
    $c->add('jpeg_quality',75,'text',5,23,NULL,1495,FALSE, $me, 23);
    $c->add('debug_image_upload',FALSE,'select',5,23,1,1500,TRUE, $me, 23);

    $c->add('tab_articleimg', NULL, 'tab', 5, 24, NULL, 0, TRUE, $me, 24);
    $c->add('fs_articleimg', NULL, 'fieldset', 5, 24, NULL, 0, TRUE, $me, 24);
    $c->add('max_image_width',160,'text',5,24,NULL,1510,TRUE, $me, 24);
    $c->add('max_image_height',160,'text',5,24,NULL,1520,TRUE, $me, 24);
    $c->add('max_image_size',1048576,'text',5,24,NULL,1530,TRUE, $me, 24);

    $c->add('tab_topicicon', NULL, 'tab', 5, 25, NULL, 0, TRUE, $me, 25);
    $c->add('fs_topicicon', NULL, 'fieldset', 5, 25, NULL, 0, TRUE, $me, 25);
    $c->add('max_topicicon_width',48,'text',5,25,NULL,1540,TRUE, $me, 25);
    $c->add('max_topicicon_height',48,'text',5,25,NULL,1550,TRUE, $me, 25);
    $c->add('max_topicicon_size',65536,'text',5,25,NULL,1560,TRUE, $me, 25);

    $c->add('tab_userphoto', NULL, 'tab', 5, 26, NULL, 0, TRUE, $me, 26);
    $c->add('fs_userphoto', NULL, 'fieldset', 5, 26, NULL, 0, TRUE, $me, 26);
    $c->add('max_photo_width',128,'text',5,26,NULL,1570,TRUE, $me, 26);
    $c->add('max_photo_height',128,'text',5,26,NULL,1580,TRUE, $me, 26);
    $c->add('max_photo_size',65536,'text',5,26,NULL,1590,TRUE, $me, 26);
    $c->add('force_photo_width',75,'text',5,26,NULL,1620,FALSE, $me, 26);
    $c->add('default_photo','http://example.com/default.jpg','text',5,26,NULL,1630,FALSE, $me, 26);

    $c->add('tab_gravatar', NULL, 'tab', 5, 27, NULL, 0, TRUE, $me, 27);
    $c->add('fs_gravatar', NULL, 'fieldset', 5, 27, NULL, 0, TRUE, $me, 27);
    $c->add('use_gravatar',FALSE,'select',5,27,1,1600,TRUE, $me, 27);
    $c->add('gravatar_rating','R','select',5,27,26,1610,FALSE, $me, 27);

    // Subgroup: Languages and Locale
    $c->add('sg_locale', NULL, 'subgroup', 6, 0, NULL, 0, TRUE, $me, 0);

    $c->add('tab_language', NULL, 'tab', 6, 28, NULL, 0, TRUE, $me, 28);
    $c->add('fs_language', NULL, 'fieldset', 6, 28, NULL, 0, TRUE, $me, 28);
    $c->add('language','english','select',6,28,NULL,350,TRUE, $me, 28);
    $c->add('language_files',array('en'=>'english_utf-8', 'de'=>'german_formal_utf-8'),'*text',6,28,NULL,470,FALSE, $me, 28);
    $c->add('languages',array('en'=>'English', 'de'=>'Deutsch'),'*text',6,28,NULL,480,FALSE, $me, 28);

    $c->add('tab_locale', NULL, 'tab', 6, 29, NULL, 0, TRUE, $me, 29);
    $c->add('fs_locale', NULL, 'fieldset', 6, 29, NULL, 0, TRUE, $me, 29);
    $c->add('locale','en_GB','text',6,29,NULL,360,TRUE, $me, 29);
    $c->add('date','%A, %B %d %Y @ %I:%M %p %Z','text',6,29,NULL,370,TRUE, $me, 29);
    $c->add('daytime','%m/%d %I:%M%p','text',6,29,NULL,380,TRUE, $me, 29);
    $c->add('shortdate','%x','text',6,29,NULL,390,TRUE, $me, 29);
    $c->add('dateonly','%d-%b','text',6,29,NULL,400,TRUE, $me, 29);
    $c->add('timeonly','%I:%M%p','text',6,29,NULL,410,TRUE, $me, 29);
    $c->add('week_start','Sun','select',6,29,14,420,TRUE, $me, 29);
    $c->add('hour_mode',12,'select',6,29,6,430,TRUE, $me, 29);
    $c->add('thousand_separator',",",'text',6,29,NULL,440,TRUE, $me, 29);
    $c->add('decimal_separator',".",'text',6,29,NULL,450,TRUE, $me, 29);
    $c->add('decimal_count',"2",'text',6,29,NULL,460,TRUE, $me, 29);
    $c->add('timezone','UTC','select',6,29,NULL,490,FALSE, $me, 29);

    // Subgroup: Miscellaneous
    $c->add('sg_misc', NULL, 'subgroup', 7, 0, NULL, 0, TRUE, $me, 0);

    $c->add('tab_cookies', NULL, 'tab', 7, 30, NULL, 0, TRUE, $me, 30);
    $c->add('fs_cookies', NULL, 'fieldset', 7, 30, NULL, 0, TRUE, $me, 30);
    $c->add('cookie_session','gl_session','text',7,30,NULL,530,TRUE, $me, 30);
    $c->add('cookie_name','geeklog','text',7,30,NULL,540,TRUE, $me, 30);
    $c->add('cookie_password','password','text',7,30,NULL,550,TRUE, $me, 30);
    $c->add('cookie_theme','theme','text',7,30,NULL,560,TRUE, $me, 30);
    $c->add('cookie_language','language','text',7,30,NULL,570,TRUE, $me, 30);
    $c->add('cookie_tzid','timezone','text',7,30,NULL,575,TRUE, $me, 30);
    $c->add('cookie_anon_name','anon_name','text',7,30,NULL,577,TRUE, $me, 30);
    $c->add('cookie_ip',0,'select',7,30,0,580,TRUE, $me, 30);
    $c->add('default_perm_cookie_timeout',28800,'select',7,30,NULL,590,TRUE, $me, 30);
    $c->add('session_cookie_timeout',7200,'text',7,30,NULL,600,TRUE, $me, 30);
    $c->add('cookie_path','/','text',7,30,NULL,610,TRUE, $me, 30);
    $c->add('cookiedomain','','text',7,30,NULL,620,TRUE, $me, 30);
    $c->add('cookiesecure',FALSE,'select',7,30,1,630,TRUE, $me, 30);

    $c->add('tab_misc', NULL, 'tab', 7, 31, NULL, 0, TRUE, $me, 31);
    $c->add('fs_misc', NULL, 'fieldset', 7, 31, NULL, 0, TRUE, $me, 31);
    $c->add('notification',array(),'%select',7,31,25,800,TRUE, $me, 31);
    $c->add('cron_schedule_interval',0,'text',7,31,NULL,860,TRUE, $me, 31);
    $c->add('disable_autolinks',0,'select',7,31,0,1750,TRUE, $me, 31);
    $c->add('clickable_links',1,'select',7,31,1,1753,TRUE, $me, 31);
    $c->add('compressed_output',0,'select',7,31,1,1756,TRUE, $me, 31);
    $c->add('frame_options','DENY','select',7,31,22,1758,TRUE, $me, 31);

    $c->add('tab_debug', NULL, 'tab', 7, 32, NULL, 0, TRUE, $me, 32);
    $c->add('fs_debug', NULL, 'fieldset', 7, 32, NULL, 0, TRUE, $me, 32);
    $c->add('rootdebug',FALSE,'select',7,32,1,520,TRUE, $me, 32);

    $c->add('tab_daily_digest', NULL, 'tab', 7, 33, NULL, 0, TRUE, $me, 33);
    $c->add('fs_daily_digest', NULL, 'fieldset', 7, 33, NULL, 0, TRUE, $me, 33);
    $c->add('emailstories',0,'select',7,33,0,930,TRUE, $me, 33);
    $c->add('emailstorieslength',1,'text',7,33,NULL,940,TRUE, $me, 33);
    $c->add('emailstoriesperdefault',0,'select',7,33,0,950,TRUE, $me, 33);

    $c->add('tab_htmlfilter', NULL, 'tab', 7, 34, NULL, 0, TRUE, $me, 34);
    $c->add('fs_htmlfilter', NULL, 'fieldset', 7, 34, NULL, 0, TRUE, $me, 34);
    $c->add('user_html',array ('p' => array(), 'b' => array(), 'strong' => array(),'i' => array(), 'a' => array('href' => 1, 'title' => 1, 'rel' => 1),'em'     => array(),'br'     => array(),'tt'     => array(),'hr'     => array(),        'li'     => array(), 'ol'     => array(), 'ul'     => array(), 'code' => array(), 'pre'    => array()),'**placeholder',7,34,NULL,1710,TRUE, $me, 34);
    $c->add('admin_html',array ('p' => array('class' => 1, 'id' => 1, 'align' => 1), 'div' => array('class' => 1, 'id' => 1), 'span' => array('class' => 1, 'id' => 1), 'table' => array('class' => 1, 'id' => 1, 'width' => 1, 'border' => 1, 'cellspacing' => 1, 'cellpadding' => 1), 'tr' => array('class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1), 'th' => array('class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1, 'colspan' => 1, 'rowspan' => 1), 'td' => array('class' => 1, 'id' => 1, 'align' => 1, 'valign' => 1, 'colspan' => 1, 'rowspan' => 1)),'**placeholder',7,34,NULL,1720,TRUE, $me, 34);
    $c->add('advanced_html',array ('img' => array('width' => 1, 'height' => 1, 'src' => 1, 'align' => 1, 'valign' => 1, 'border' => 1, 'alt' => 1)),'**placeholder',7,34,NULL,1721,TRUE, $me, 34);
    $c->add('skip_html_filter_for_root',0,'select',7,34,0,1730,TRUE, $me, 34);
    $c->add('allowed_protocols',array('http','ftp','https'),'%text',7,34,NULL,1740,TRUE, $me, 34);

    $c->add('tab_censoring', NULL, 'tab', 7, 35, NULL, 0, TRUE, $me, 35);
    $c->add('fs_censoring', NULL, 'fieldset', 7, 35, NULL, 0, TRUE, $me, 35);
    $c->add('censormode',1,'select',7,35,18,1760,TRUE, $me, 35);
    $c->add('censorreplace','*censored*','text',7,35,NULL,1770,TRUE, $me, 35);
    $c->add('censorlist', array('fuck','cunt','fucker','fucking','pussy','cock','c0ck',' cum ','twat','clit','bitch','fuk','fuking','motherfucker'),'%text',7,35,NULL,1780,TRUE, $me, 35);

    $c->add('tab_iplookup', NULL, 'tab', 7, 36, NULL, 0, TRUE, $me, 36);
    $c->add('fs_iplookup', NULL, 'fieldset', 7, 36, NULL, 0, TRUE, $me, 36);
    $c->add('ip_lookup','/nettools/whois.php?domain=*','text',7,36,NULL,1790,FALSE, $me, 36);

    
    $c->add('tab_permissions', NULL, 'tab', 7, 37, NULL, 0, TRUE, $me, 37);
    $c->add('fs_perm_story', NULL, 'fieldset', 7, 37, NULL, 0, TRUE, $me, 37);
    $c->add('default_permissions_story',array(3, 2, 2, 2),'@select',7,37,12,1820,TRUE, $me, 37);
    $c->add('fs_perm_topic', NULL, 'fieldset', 7, 38, NULL, 0, TRUE, $me, 37);
    $c->add('default_permissions_topic',array(3, 2, 2, 2),'@select',7,38,12,1830,TRUE, $me, 37);
    $c->add('fs_perm_block', NULL, 'fieldset', 7, 39, NULL, 0, TRUE, $me, 37);
    $c->add('default_permissions_block',array(3, 2, 2, 2),'@select',7,39,12,1810,TRUE, $me, 37);
    $c->add('fs_autotag_permissions', NULL, 'fieldset', 7, 41, NULL, 0, TRUE, $me, 37);
    $c->add('autotag_permissions_story', array(2, 2, 2, 2), '@select', 7, 41, 28, 1870, TRUE, $me, 37);
    $c->add('autotag_permissions_user', array(2, 2, 2, 2), '@select', 7, 41, 28, 1880, TRUE, $me, 37);

    $c->add('tab_webservices', NULL, 'tab', 7, 40, NULL, 0, TRUE, $me, 40);
    $c->add('fs_webservices', NULL, 'fieldset', 7, 40, NULL, 0, TRUE, $me, 40);
    $c->add('disable_webservices',   1, 'select', 7, 40, 0, 1840, TRUE, $me, 40);
    $c->add('restrict_webservices',  0, 'select', 7, 40, 0, 1850, TRUE, $me, 40);
    $c->add('atom_max_stories',     10, 'text',   7, 40, 0, 1860, TRUE, $me, 40);
    
}

?>
