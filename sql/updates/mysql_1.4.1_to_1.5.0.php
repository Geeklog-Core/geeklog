<?php

// remove time zone table since its included into PEAR now
$_SQL[] = "DROP TABLE " . $_DB_table_prefix . 'tzcodes';
$_SQL[] = "ALTER TABLE {$_TABLES['userprefs']} CHANGE `tzid` `tzid` VARCHAR(125) NOT NULL DEFAULT ''";
// change former default values to '' so users dont all have edt for no reason
$_SQL[] = "UPDATE `{$_TABLES['userprefs']}` set tzid = ''";
// User submissions may have body text.
$_SQL[] = "ALTER TABLE `{$_TABLES['storysubmission']}` ADD bodytext TEXT AFTER introtext";

// new comment code: close comments
$_SQL[] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (1,'Comments Closed')";

// Increase block function size to accept arguments:
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} CHANGE phpblockfn phpblockfn VARCHAR(128)";

// New fields to store HTTP Last-Modified and ETag headers
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD rdf_last_modified VARCHAR(40) DEFAULT NULL AFTER rdfupdated";
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD rdf_etag VARCHAR(40) DEFAULT NULL AFTER rdf_last_modified";

function create_ConfValues()
{
    global $_TABLES;
    // Create conf_values table for new configuration system
    DB_query ("CREATE TABLE {$_TABLES['conf_values']} (
      name varchar(50) default NULL,
      value text,
      type varchar(50) default NULL,
      group_name varchar(50) default NULL,
      default_value text,
      display_name varchar(50) default NULL,
      subgroup varchar(50) default NULL,
      selectionArray text default NULL,
      sort_order int(11) default NULL,
      fieldset varchar(30) default NULL
    ) TYPE=MyISAM
    ");

    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('path_html','s:0:\"\";','text','Core','s:0:\"\";','HTML Path','Site','',10,'Paths')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('site_url','s:0:\"\";','text','Core','s:0:\"\";','Site URL','Site','',20,'Site')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('site_admin_url','s:0:\"\";','text','Core','s:0:\"\";','Admin URL','Site','',30,'Site')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('site_mail','s:0:\"\";','text','Core','s:0:\"\";','Site E-Mail','Site','',40,'Mail')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('noreply_mail','s:0:\"\";','text','Core','s:0:\"\";','No-Reply E-Mail','Site','',50,'Mail')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('site_name','s:0:\"\";','text','Core','s:0:\"\";','Site Name','Site','',60,'Site')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('site_slogan','s:0:\"\";','text','Core','s:0:\"\";','Slogan','Site','',70,'Site')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('microsummary_short','s:4:\"GL: \";','text','Core','s:4:\"GL: \";','Microsummary','Site','',80,'Site')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('path_log','s:0:\"\";','text','Core','s:0:\"\";','Log','Site','',90,'Paths')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('path_language','s:0:\"\";','text','Core','s:0:\"\";','Language','Site','',100,'Paths')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('backup_path','s:0:\"\";','text','Core','s:0:\"\";','Backup','Site','',110,'Paths')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('path_data','s:0:\"\";','text','Core','s:0:\"\";','Data','Site','',120,'Paths')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('path_images','s:0:\"\";','text','Core','s:0:\"\";','Images','Site','',130,'Paths')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('path_pear','s:0:\"\";','text','Core','s:0:\"\";','Pear Path','Site','',140,'Pear')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('mail_settings','a:8:{s:7:\"backend\";s:4:\"mail\";s:13:\"sendmail_path\";s:17:\"/usr/bin/sendmail\";s:13:\"sendmail_args\";s:0:\"\";s:4:\"host\";s:16:\"smtp.example.com\";s:4:\"port\";s:2:\"25\";s:4:\"auth\";b:0;s:8:\"username\";s:13:\"smtp-username\";s:8:\"password\";s:13:\"smtp-password\";}','@text','Core','a:8:{s:7:\"backend\";s:4:\"mail\";s:13:\"sendmail_path\";s:17:\"/usr/bin/sendmail\";s:13:\"sendmail_args\";s:0:\"\";s:4:\"host\";s:16:\"smtp.example.com\";s:4:\"port\";s:2:\"25\";s:4:\"auth\";b:0;s:8:\"username\";s:13:\"smtp-username\";s:8:\"password\";s:13:\"smtp-password\";}','Mail Settings','Site','',160,'Mail')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('allow_mysqldump','i:1;','select','Core','i:1;','Allow MySQL Dump','Site','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',170,'MySQL')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('mysqldump_options','s:2:\"-Q\";','text','Core','s:2:\"-Q\";','MySQL Dump Options','Site','',180,'MySQL')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('theme','s:12:\"professional\";','text','Core','s:12:\"professional\";','Theme','Theme','',190,'Theme')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('menu_elements','a:5:{i:0;s:10:\"contribute\";i:1;s:6:\"search\";i:2;s:5:\"stats\";i:3;s:9:\"directory\";i:4;s:7:\"plugins\";}','%text','Core','a:5:{i:0;s:10:\"contribute\";i:1;s:6:\"search\";i:2;s:5:\"stats\";i:3;s:9:\"directory\";i:4;s:7:\"plugins\";}','Menu Elements','Theme','',200,'Theme')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('path_themes','s:0:\"\";','text','Core','s:0:\"\";','Themes Path','Theme','',210,'Theme')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('disable_new_user_registration','b:0;','select','Core','b:0;','Disable New Users','Users_and_Submissions','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',220,'Users')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('allow_user_themes','i:1;','select','Core','i:1;','User Themes','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',230,'Users')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('allow_user_language','i:1;','select','Core','i:1;','User Language','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',240,'Users')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('allow_user_photo','i:1;','select','Core','i:1;','User Photo','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',250,'Users')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('allow_username_change','i:0;','select','Core','i:0;','Username Changes','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',260,'Users')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('allow_account_delete','i:0;','select','Core','i:0;','Account Deletion','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',270,'Users')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hide_author_exclusion','i:0;','select','Core','i:0;','Hide Author','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',280,'Users')";

    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('have_pear','b:0;','select','Core','b:0;','Have Pear?','Site','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',145,'Pear')";


    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('show_fullname','i:0;','select','Core','i:0;','Show Fullname','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',290,'Users')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('show_servicename','b:1;','select','Core','b:1;','Show Service Name','Users_and_Submissions','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',300,'Users')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('custom_registration','b:0;','select','Core','b:0;','Custom Registration','Users_and_Submissions','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',310,'Users')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('user_logging_method','a:3:{s:8:\"standard\";b:1;s:6:\"openid\";b:0;s:8:\"3rdparty\";b:0;}','@select','Core','a:3:{s:8:\"standard\";b:1;s:6:\"openid\";b:0;s:8:\"3rdparty\";b:0;}','User Logging Method','Users_and_Submissions','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',320,'Users')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('spamx','i:128;','text','Core','i:128;','Spam-X','Users_and_Submissions','',330,'Spam-X')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('sort_admin','b:1;','select','Core','b:1;','Sort Links','Miscellaneous','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',340,'Admin')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('language','s:7:\"english\";','text','Core','s:7:\"english\";','Language','Language_and_Locale','',350,'Language')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('locale','s:5:\"en_GB\";','text','Core','s:5:\"en_GB\";','Locale','Language_and_Locale','',360,'Locale')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('date','s:26:\"%A, %B %d %Y @ %I:%M %p %Z\";','text','Core','s:26:\"%A, %B %d %Y @ %I:%M %p %Z\";','Date','Language_and_Locale','',370,'Locale')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('daytime','s:13:\"%m/%d %I:%M%p\";','text','Core','s:13:\"%m/%d %I:%M%p\";','Daytime','Language_and_Locale','',380,'Locale')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('shortdate','s:2:\"%x\";','text','Core','s:2:\"%x\";','Short Date','Language_and_Locale','',390,'Locale')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('dateonly','s:5:\"%d-%b\";','text','Core','s:5:\"%d-%b\";','Date Only','Language_and_Locale','',400,'Locale')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('timeonly','s:7:\"%I:%M%p\";','text','Core','s:7:\"%I:%M%p\";','Time Only','Language_and_Locale','',410,'Locale')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('week_start','s:3:\"Sun\";','text','Core','s:3:\"Sun\";','Week Start','Language_and_Locale','',420,'Locale')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hour_mode','i:12;','select','Core','i:12;','Hour Mode','Language_and_Locale','a:2:{i:12;s:2:\"12\";i:24;s:2:\"24\";}',430,'Locale')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('thousand_separator','s:1:\",\";','text','Core','s:1:\",\";','Thousand Separator','Language_and_Locale','',440,'Locale')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('decimal_separator','s:1:\".\";','text','Core','s:1:\".\";','Decimal Separator','Language_and_Locale','',450,'Locale')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('decimal_count','s:1:\"2\";','text','Core','s:1:\"2\";','Decimal Count','Language_and_Locale','',460,'Locale')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('language_files','a:2:{s:2:\"en\";s:13:\"english_utf-8\";s:2:\"de\";s:19:\"german_formal_utf-8\";}','*text','Core','a:2:{s:2:\"en\";s:13:\"english_utf-8\";s:2:\"de\";s:19:\"german_formal_utf-8\";}','Language Files','Language_and_Locale','',470,'Language')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('languages','a:2:{s:2:\"en\";s:7:\"English\";s:2:\"de\";s:7:\"Deutsch\";}','*text','Core','a:2:{s:2:\"en\";s:7:\"English\";s:2:\"de\";s:7:\"Deutsch\";}','Languages','Language_and_Locale','',480,'Language')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('timezone','s:9:\"Etc/GMT-6\";','text','Core','s:9:\"Etc/GMT-6\";','Timezone','Language_and_Locale','',490,'Locale')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('site_enabled','b:1;','select','Core','b:1;','Site Enabled','Site','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',500,'Site')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('site_disabled_msg','s:44:\"Geeklog Site is down. Please come back soon.\";','text','Core','s:44:\"Geeklog Site is down. Please come back soon.\";','Disabled Message','Site','',510,'Site')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('rootdebug','b:0;','select','Core','b:0;','Root Debugging','Miscellaneous','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',520,'Debug')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('cookie_session','s:10:\"gl_session\";','text','Core','s:10:\"gl_session\";','Cookie Session','Miscellaneous','',530,'Cookies')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('cookie_name','s:7:\"geeklog\";','text','Core','s:7:\"geeklog\";','Cookie Name','Miscellaneous','',540,'Cookies')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('cookie_password','s:8:\"password\";','text','Core','s:8:\"password\";','Cookie Password','Miscellaneous','',550,'Cookies')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('cookie_theme','s:5:\"theme\";','text','Core','s:5:\"theme\";','Cookie Theme','Miscellaneous','',560,'Cookies')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('cookie_language','s:8:\"language\";','text','Core','s:8:\"language\";','Cookie Language','Miscellaneous','',570,'Cookies')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('cookie_ip','i:0;','select','Core','i:0;','Cookies embed IP?','Miscellaneous','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',580,'Cookies')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('default_perm_cookie_timeout','i:28800;','text','Core','i:28800;','Permanent Timeout','Miscellaneous','',590,'Cookies')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('session_cookie_timeout','i:7200;','text','Core','i:7200;','Session Timeout','Miscellaneous','',600,'Cookies')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('cookie_path','s:1:\"/\";','text','Core','s:1:\"/\";','Cookie Path','Miscellaneous','',610,'Cookies')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('cookiedomain','s:0:\"\";','text','Core','s:0:\"\";','Cookie Domain','Miscellaneous','',620,'Cookies')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('cookiesecure','i:0;','text','Core','i:0;','Cookie Secure','Miscellaneous','',630,'Cookies')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('lastlogin','b:1;','select','Core','b:1;','Store Last Login?','Users_and_Submissions','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',640,'Login Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('ostype','s:5:\"Linux\";','text','Core','s:5:\"Linux\";','OS Type','Miscellaneous','',650,'Miscellaneous')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('pdf_enabled','i:0;','select','Core','i:0;','PDF Enabled?','Miscellaneous','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',660,'Miscellaneous')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('num_search_results','i:10;','text','Core','i:10;','Number of Search Results','Site','',670,'Search')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('loginrequired','i:0;','select','Core','i:0;','Login Required?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',680,'Login Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('submitloginrequired','i:0;','select','Core','i:0;','Submit Login Required?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',690,'Login Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('commentsloginrequired','i:0;','select','Core','i:0;','Comment Login Required?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',700,'Login Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('statsloginrequired','i:0;','select','Core','i:0;','Stats Login Required?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',710,'Login Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('searchloginrequired','i:0;','select','Core','i:0;','Search Login Required?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',720,'Login Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('profileloginrequired','i:0;','select','Core','i:0;','Profile Login Required?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',730,'Login Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('emailuserloginrequired','i:0;','select','Core','i:0;','E-Mail User Login Required?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',740,'Login Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('emailstoryloginrequired','i:0;','select','Core','i:0;','E-Mail Story Login Required?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',750,'Login Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('directoryloginrequired','i:0;','select','Core','i:0;','Directory Login Required?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',760,'Login Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('storysubmission','i:1;','select','Core','i:1;','Story Submission Queue?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',770,'Submission Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('usersubmission','i:0;','select','Core','i:0;','User Submission Queue?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',780,'User Submission')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('listdraftstories','i:0;','select','Core','i:0;','List Draft Stories?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',790,'Submission Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('notification','a:0:{}','%text','Core','a:0:{}','Notifications','Miscellaneous','',800,'Miscellaneous')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('postmode','s:9:\"plaintext\";','select','Core','s:9:\"plaintext\";','Post Mode','Users_and_Submissions','a:2:{s:5:\"Plain\";s:9:\"plaintext\";s:4:\"HTML\";s:4:\"html\";}',810,'Submission Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('speedlimit','i:45;','text','Core','i:45;','Post Speed Limit','Users_and_Submissions','',820,'Submission Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('skip_preview','i:0;','text','Core','i:0;','Skip Preview in Posts','Users_and_Submissions','',830,'Submission Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('advanced_editor','b:0;','select','Core','b:0;','Advanced Editor?','Users_and_Submissions','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',840,'Submission Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('wikitext_editor','b:0;','select','Core','b:0;','Wikitext Editor?','Users_and_Submissions','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',850,'Submission Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('cron_schedule_interval','i:86400;','text','Core','i:86400;','Cron Schedule Interval','Miscellaneous','',860,'Miscellaneous')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('sortmethod','s:7:\"sortnum\";','text','Core','s:7:\"sortnum\";','Topic Sort Method','Topics_and_Daily_Digest','',870,'Topic')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('showstorycount','i:1;','select','Core','i:1;','Show Story Count?','Topics_and_Daily_Digest','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',880,'Topic')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('showsubmissioncount','i:1;','select','Core','i:1;','Show Submission Count?','Topics_and_Daily_Digest','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',890,'Topic')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hide_home_link','i:0;','select','Core','i:0;','Hide Home Link?','Topics_and_Daily_Digest','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',900,'Topic')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('whosonline_threshold','i:300;','text','Core','i:300;','Threshold','Topics_and_Daily_Digest','',910,'Who\'s Online')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('whosonline_anonymous','i:0;','select','Core','i:0;','Anonymous?','Topics_and_Daily_Digest','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',920,'Who\'s Online')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('emailstories','i:0;','select','Core','i:0;','E-Mail Stories?','Topics_and_Daily_Digest','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',930,'Daily Digest')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('emailstorieslength','i:1;','text','Core','i:1;','E-Mail Stories Length','Topics_and_Daily_Digest','',940,'Daily Digest')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('emailstoriesperdefault','i:0;','select','Core','i:0;','E-Mail Stories Default?','Topics_and_Daily_Digest','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',950,'Daily Digest')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('allow_domains','s:0:\"\";','text','Core','s:0:\"\";','Automatic Allow Domains','Users_and_Submissions','',960,'User Submission')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('disallow_domains','s:0:\"\";','text','Core','s:0:\"\";','Automatic Disallow Domains','Users_and_Submissions','',970,'User Submission')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('newstoriesinterval','i:86400;','text','Core','i:86400;','New Stories Interval','Topics_and_Daily_Digest','',980,'What\'s New')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('newcommentsinterval','i:172800;','text','Core','i:172800;','New Comments Interval','Topics_and_Daily_Digest','',990,'What\'s New')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('newtrackbackinterval','i:172800;','text','Core','i:172800;','New Trackback Interval','Topics_and_Daily_Digest','',1000,'What\'s New')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hidenewstories','i:0;','select','Core','i:0;','Hide New Stories','Topics_and_Daily_Digest','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1010,'What\'s New')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hidenewcomments','i:0;','select','Core','i:0;','Hide New Comments','Topics_and_Daily_Digest','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1020,'What\'s New')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hidenewtrackbacks','i:0;','select','Core','i:0;','Hide New Trackbacks','Topics_and_Daily_Digest','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1030,'What\'s New')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hidenewplugins','i:0;','select','Core','i:0;','Hide New Plugins','Topics_and_Daily_Digest','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1040,'What\'s New')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('title_trim_length','i:20;','text','Core','i:20;','Title Trim','Topics_and_Daily_Digest','',1050,'What\'s New')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('trackback_enabled','b:1;','select','Core','b:1;','Trackback?','Stories_and_Trackback','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',1060,'Trackback')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('pingback_enabled','b:1;','select','Core','b:1;','Pingback?','Stories_and_Trackback','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',1070,'Pingback')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('ping_enabled','b:1;','select','Core','b:1;','Ping Enabled?','Stories_and_Trackback','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',1080,'Pingback')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('trackback_code','i:0;','select','Core','i:0;','Trackback Default','Stories_and_Trackback','a:2:{s:4:\"True\";i:0;s:5:\"False\";i:-1;}',1090,'Trackback')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('multiple_trackbacks','i:0;','select','Core','i:0;','Multiple Trackbacks','Stories_and_Trackback','a:3:{s:6:\"Reject\";i:0;s:16:\"Only Keep Latest\";i:1;s:20:\"Allow Multiple Posts\";i:2;}',1100,'Trackback')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('trackbackspeedlimit','i:300;','text','Core','i:300;','Trackback Speed Limit','Stories_and_Trackback','',1110,'Trackback')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('check_trackback_link','i:2;','select','Core','i:2;','Check Trackbacks','Stories_and_Trackback','',1120,'Trackback')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('pingback_self','i:0;','select','Core','i:0;','Pingback Self?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1130,'Pingback')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('pingback_excerpt','b:1;','select','Core','b:1;','Pingback Excerpt?','Stories_and_Trackback','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',1140,'Pingback')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('link_documentation','i:1;','select','Core','i:1;','Link Documentation?','Miscellaneous','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1150,'Admin')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('link_versionchecker','i:1;','select','Core','i:1;','Link Version Checker?','Miscellaneous','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1160,'Admin')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('maximagesperarticle','i:5;','text','Core','i:5;','Max Images per Article','Stories_and_Trackback','',1170,'Story')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('limitnews','i:10;','text','Core','i:10;','Limit News','Stories_and_Trackback','',1180,'Story')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('minnews','i:1;','text','Core','i:1;','Minimum News','Stories_and_Trackback','',1190,'Story')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('contributedbyline','i:1;','select','Core','i:1;','Show Contributed By?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1200,'Story')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hideviewscount','i:0;','select','Core','i:0;','Hide Views Count?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1210,'Story')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hideemailicon','i:0;','select','Core','i:0;','Hide E-Mail Icon?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1220,'Story')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hideprintericon','i:0;','select','Core','i:0;','Hide Print Icon?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1230,'Story')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('allow_page_breaks','i:1;','select','Core','i:1;','Allow Page Breaks?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1240,'Story')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('page_break_comments','s:4:\"last\";','select','Core','s:4:\"last\";','Comments on Page Breaks','Stories_and_Trackback','a:3:{s:4:\"Last\";s:4:\"last\";s:5:\"First\";s:5:\"first\";s:3:\"All\";s:3:\"all\";}',1250,'Story')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('article_image_align','s:5:\"right\";','select','Core','s:5:\"right\";','Article Image Align','Stories_and_Trackback','a:2:{s:5:\"Right\";s:5:\"right\";s:4:\"Left\";s:4:\"left\";}',1260,'Story')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('show_topic_icon','i:1;','select','Core','i:1;','Show Topic Icon?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1270,'Story')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('draft_flag','i:0;','select','Core','i:0;','Draft Flag?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1280,'Story')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('frontpage','i:1;','select','Core','i:1;','Frontpage?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1290,'Story')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hide_no_news_msg','i:0;','select','Core','i:0;','Hide No News Message?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1300,'Story')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hide_main_page_navigation','i:0;','select','Core','i:0;','Hide Main Page Navigation?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1310,'Story')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('onlyrootfeatures','i:0;','select','Core','i:0;','Only Root can Feature?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1320,'Story')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('aftersave_story','s:4:\"item\";','select','Core','s:4:\"item\";','After Saving Story','Stories_and_Trackback','a:4:{s:15:\"Forward to page\";s:4:\"item\";s:12:\"Display List\";s:4:\"list\";s:12:\"Display Home\";s:4:\"home\";s:18:\"Display Admin\";s:5:\"admin\";}',1330,'Story')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('aftersave_user','s:4:\"item\";','select','Core','s:4:\"item\";','After Saving User','Stories_and_Trackback','a:4:{s:15:\"Forward to page\";s:4:\"item\";s:12:\"Display List\";s:4:\"list\";s:12:\"Display Home\";s:4:\"home\";s:18:\"Display Admin\";s:5:\"admin\";}',1340,'Story')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('show_right_blocks','b:0;','select','Core','b:0;','Show Right Blocks?','Theme','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',1350,'Advanced Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('showfirstasfeatured','i:0;','select','Core','i:0;','Show First as Featured?','Theme','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1360,'Advanced Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('left_blocks_in_footer','i:0;','select','Core','i:0;','Left Blocks in Footer?','Theme','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1370,'Advanced Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('backend','i:1;','select','Core','i:1;','Backend?','Site','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1380,'RSS')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('rdf_file','s:0:\"\";','text','Core','s:0:\"\";','RDF File','Site','',1390,'RSS')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('rdf_limit','i:10;','text','Core','i:10;','RDF Limit','Site','',1400,'RSS')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('rdf_storytext','i:1;','text','Core','i:1;','RDF Storytext','Site','',1410,'RSS')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('rdf_language','s:5:\"en-gb\";','text','Core','s:5:\"en-gb\";','RDF Language','Site','',1420,'RSS')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('syndication_max_headlines','i:0;','text','Core','i:0;','Maximum Headlines','Site','',1430,'RSS')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('copyright','s:4:\"2007\";','text','Core','s:4:\"2007\";','Copyright Year','Site','',1440,'Site')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('image_lib','s:0:\"\";','select','Core','s:0:\"\";','Image Library','Images','a:4:{s:4:\"None\";s:0:\"\";s:6:\"Netpbm\";s:6:\"netpbm\";s:11:\"ImageMagick\";s:11:\"imagemagick\";s:5:\"gdLib\";s:5:\"gdlib\";}',1450,'Image Library')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('path_to_mogrify','s:0:\"\";','text','Core','s:0:\"\";','Path to Mogrify','Images','',1460,'Image Library')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('path_to_netpbm','s:0:\"\";','text','Core','s:0:\"\";','Path to Netpbm','Images','',1470,'Image Library')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('debug_image_upload','b:1;','select','Core','b:1;','Debug Image Uploading?','Images','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',1480,'Upload')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('keep_unscaled_image','i:0;','select','Core','i:0;','Keep Unscaled Image?','Images','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1490,'Upload')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('allow_user_scaling','i:1;','select','Core','i:1;','Allow User Scaling?','Images','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1500,'Upload')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('max_image_width','i:160;','text','Core','i:160;','Max Image Width?','Images','',1510,'Image')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('max_image_height','i:160;','text','Core','i:160;','Max Image Height?','Images','',1520,'Image')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('max_image_size','i:1048576;','text','Core','i:1048576;','Max Image Size?','Images','',1530,'Image')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('max_topicicon_width','i:48;','text','Core','i:48;','Max Topic Icon Width?','Images','',1540,'Topic Icons')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('max_topicicon_height','i:48;','text','Core','i:48;','Max Topic Icon Height?','Images','',1550,'Topic Icons')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('max_topicicon_size','i:65536;','text','Core','i:65536;','Max Topic Icon Size?','Images','',1560,'Topic Icons')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('max_photo_width','i:128;','text','Core','i:128;','Max Photo Width?','Images','',1570,'Photos')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('max_photo_height','i:128;','text','Core','i:128;','Max Photo Height?','Images','',1580,'Photos')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('max_photo_size','i:65536;','text','Core','i:65536;','Max Photo Size?','Images','',1590,'Photos')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('use_gravatar','b:0;','select','Core','b:0;','Use Gravatar?','Images','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',1600,'Gravatar')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('gravatar_rating','s:1:\"R\";','text','Core','s:1:\"R\";','Gravatar Rating Allowed','Images','',1610,'Gravatar')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('force_photo_width','i:75;','text','Core','i:75;','Force Photo Width','Images','',1620,'Photos')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('default_photo','s:30:\"http://example.com/default.jpg\";','text','Core','s:30:\"http://example.com/default.jpg\";','Default Photo','Images','',1630,'Photos')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('commentspeedlimit','i:45;','text','Core','i:45;','Comment Speed Limit','Users_and_Submissions','',1640,'Comments')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('comment_limit','i:100;','text','Core','i:100;','Comment Limit','Users_and_Submissions','',1650,'Comments')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('comment_mode','s:8:\"threaded\";','select','Core','s:8:\"threaded\";','Comment Mode','Users_and_Submissions','a:4:{s:8:\"Threaded\";s:8:\"threaded\";s:6:\"Nested\";s:6:\"nested\";s:11:\"No Comments\";s:10:\"nocomments\";s:4:\"Flat\";s:4:\"flat\";}:',1660,'Comments')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('comment_code','i:0;','select','Core','i:0;','Comment Code','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1670,'Comments')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('passwordspeedlimit','i:300;','text','Core','i:300;','Password Speed Limit','Users_and_Submissions','',1680,'Login Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('login_attempts','i:3;','text','Core','i:3;','Login Attempts','Users_and_Submissions','',1690,'Login Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('login_speedlimit','i:300;','text','Core','i:300;','Login Speed Limit','Users_and_Submissions','',1700,'Login Settings')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('user_html','a:14:{s:1:\"p\";a:0:{}s:1:\"b\";a:0:{}s:6:\"strong\";a:0:{}s:1:\"i\";a:0:{}s:1:\"a\";a:3:{s:4:\"href\";i:1;s:5:\"title\";i:1;s:3:\"rel\";i:1;}s:2:\"em\";a:0:{}s:2:\"br\";a:0:{}s:2:\"tt\";a:0:{}s:2:\"hr\";a:0:{}s:2:\"li\";a:0:{}s:2:\"ol\";a:0:{}s:2:\"ul\";a:0:{}s:4:\"code\";a:0:{}s:3:\"pre\";a:0:{}}','**placeholder','Core','a:14:{s:1:\"p\";a:0:{}s:1:\"b\";a:0:{}s:6:\"strong\";a:0:{}s:1:\"i\";a:0:{}s:1:\"a\";a:3:{s:4:\"href\";i:1;s:5:\"title\";i:1;s:3:\"rel\";i:1;}s:2:\"em\";a:0:{}s:2:\"br\";a:0:{}s:2:\"tt\";a:0:{}s:2:\"hr\";a:0:{}s:2:\"li\";a:0:{}s:2:\"ol\";a:0:{}s:2:\"ul\";a:0:{}s:4:\"code\";a:0:{}s:3:\"pre\";a:0:{}}','User HTML','Miscellaneous','',1710,'HTML Filtering')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('admin_html','a:7:{s:1:\"p\";a:3:{s:5:\"class\";i:1;s:2:\"id\";i:1;s:5:\"align\";i:1;}s:3:\"div\";a:2:{s:5:\"class\";i:1;s:2:\"id\";i:1;}s:4:\"span\";a:2:{s:5:\"class\";i:1;s:2:\"id\";i:1;}s:5:\"table\";a:6:{s:5:\"class\";i:1;s:2:\"id\";i:1;s:5:\"width\";i:1;s:6:\"border\";i:1;s:11:\"cellspacing\";i:1;s:11:\"cellpadding\";i:1;}s:2:\"tr\";a:4:{s:5:\"class\";i:1;s:2:\"id\";i:1;s:5:\"align\";i:1;s:6:\"valign\";i:1;}s:2:\"th\";a:6:{s:5:\"class\";i:1;s:2:\"id\";i:1;s:5:\"align\";i:1;s:6:\"valign\";i:1;s:7:\"colspan\";i:1;s:7:\"rowspan\";i:1;}s:2:\"td\";a:6:{s:5:\"class\";i:1;s:2:\"id\";i:1;s:5:\"align\";i:1;s:6:\"valign\";i:1;s:7:\"colspan\";i:1;s:7:\"rowspan\";i:1;}}','**placeholder','Core','a:7:{s:1:\"p\";a:3:{s:5:\"class\";i:1;s:2:\"id\";i:1;s:5:\"align\";i:1;}s:3:\"div\";a:2:{s:5:\"class\";i:1;s:2:\"id\";i:1;}s:4:\"span\";a:2:{s:5:\"class\";i:1;s:2:\"id\";i:1;}s:5:\"table\";a:6:{s:5:\"class\";i:1;s:2:\"id\";i:1;s:5:\"width\";i:1;s:6:\"border\";i:1;s:11:\"cellspacing\";i:1;s:11:\"cellpadding\";i:1;}s:2:\"tr\";a:4:{s:5:\"class\";i:1;s:2:\"id\";i:1;s:5:\"align\";i:1;s:6:\"valign\";i:1;}s:2:\"th\";a:6:{s:5:\"class\";i:1;s:2:\"id\";i:1;s:5:\"align\";i:1;s:6:\"valign\";i:1;s:7:\"colspan\";i:1;s:7:\"rowspan\";i:1;}s:2:\"td\";a:6:{s:5:\"class\";i:1;s:2:\"id\";i:1;s:5:\"align\";i:1;s:6:\"valign\";i:1;s:7:\"colspan\";i:1;s:7:\"rowspan\";i:1;}}','Admin HTML','Miscellaneous','',1720,'HTML Filtering')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('skip_html_filter_for_root','i:0;','select','Core','i:0;','Skip HTML Filter for Root?','Miscellaneous','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1730,'HTML Filtering')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('allowed_protocols','a:3:{i:0;s:4:\"http\";i:1;s:3:\"ftp\";i:2;s:5:\"https\";}','%text','Core','a:3:{i:0;s:4:\"http\";i:1;s:3:\"ftp\";i:2;s:5:\"https\";}','Allowed Protocols','Site','',1740,'Site')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('disable_autolinks','i:0;','select','Core','i:0;','Disable Autolinks?','Miscellaneous','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1750,'Miscellaneous')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('censormode','i:1;','select','Core','i:1;','Censor Mode?','Miscellaneous','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1760,'Censoring')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('censorreplace','s:12:\"*censormode*\";','text','Core','s:12:\"*censormode*\";','Censor Replace','Miscellaneous','',1770,'Censoring')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('censorlist','a:14:{i:0;s:4:\"fuck\";i:1;s:4:\"cunt\";i:2;s:6:\"fucker\";i:3;s:7:\"fucking\";i:4;s:5:\"pussy\";i:5;s:4:\"cock\";i:6;s:4:\"c0ck\";i:7;s:5:\" cum \";i:8;s:4:\"twat\";i:9;s:4:\"clit\";i:10;s:5:\"bitch\";i:11;s:3:\"fuk\";i:12;s:6:\"fuking\";i:13;s:12:\"motherfucker\";}','%text','Core','a:14:{i:0;s:4:\"fuck\";i:1;s:4:\"cunt\";i:2;s:6:\"fucker\";i:3;s:7:\"fucking\";i:4;s:5:\"pussy\";i:5;s:4:\"cock\";i:6;s:4:\"c0ck\";i:7;s:5:\" cum \";i:8;s:4:\"twat\";i:9;s:4:\"clit\";i:10;s:5:\"bitch\";i:11;s:3:\"fuk\";i:12;s:6:\"fuking\";i:13;s:12:\"motherfucker\";}','Censor List','Miscellaneous','',1780,'Censoring')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('ip_lookup','s:28:\"/nettools/whois.php?domain=*\";','text','Core','s:28:\"/nettools/whois.php?domain=*\";','IP Lookup','Miscellaneous','',1790,'IP Lookup')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('url_rewrite','b:0;','select','Core','b:0;','URL Rewrite','Site','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',1800,'Site')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('default_permissions_block','a:4:{i:0;i:3;i:1;i:2;i:2;i:2;i:3;i:2;}','@select','Core','a:4:{i:0;i:3;i:1;i:2;i:2;i:2;i:3;i:2;}','Block Default Permissions','Miscellaneous','a:3:{s:9:\"No access\";i:0;s:9:\"Read-Only\";i:2;s:10:\"Read-Write\";i:3;}',1810,'Default Permission')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('default_permissions_story','a:4:{i:0;i:3;i:1;i:2;i:2;i:2;i:3;i:2;}','@select','Core','a:4:{i:0;i:3;i:1;i:2;i:2;i:2;i:3;i:2;}','Story Default Permissions','Miscellaneous','a:3:{s:9:\"No access\";i:0;s:9:\"Read-Only\";i:2;s:10:\"Read-Write\";i:3;}',1820,'Default Permission')";
    $C_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('default_permissions_topic','a:4:{i:0;i:3;i:1;i:2;i:2;i:2;i:3;i:2;}','@select','Core','a:4:{i:0;i:3;i:1;i:2;i:2;i:2;i:3;i:2;}','Topic Default Permissions','Miscellaneous','a:3:{s:9:\"No access\";i:0;s:9:\"Read-Only\";i:2;s:10:\"Read-Write\";i:3;}',1830,'Default Permission')";

    INST_updateDB($C_DATA);

}


function upgrade_PollsPlugin()
{
    global $_TABLES;

    // Polls plugin updates
    $check_sql = "SELECT pi_name FROM {$_TABLES['plugins']} WHERE pi_name = 'polls';";
    $check_rst = DB_query ($check_sql);
    if (DB_numRows($check_rst) == 1) {
        $P_SQL = array();
        $P_SQL[] = "RENAME TABLE `{$_TABLES['pollquestions']}` TO `{$_TABLES['polltopics']}`;";
        $P_SQL[] = "ALTER TABLE `{$_TABLES['polltopics']}` CHANGE `question` `topic` VARCHAR( 255 )  NULL DEFAULT NULL";
        $P_SQL[] = "ALTER TABLE `{$_TABLES['polltopics']}` CHANGE `qid` `pid` VARCHAR( 20 ) NOT NULL";
        $P_SQL[] = "ALTER TABLE `{$_TABLES['polltopics']}` ADD questions int(11) default '0' NOT NULL AFTER voters";
        $P_SQL[] = "ALTER TABLE `{$_TABLES['polltopics']}` ADD open tinyint(4) NOT NULL default '1' AFTER display";
        $P_SQL[] = "ALTER TABLE `{$_TABLES['polltopics']}` ADD hideresults tinyint(1) NOT NULL default '1' AFTER open";
        $P_SQL[] = "ALTER TABLE `{$_TABLES['pollanswers']}` CHANGE `qid` `pid` VARCHAR( 20 ) NOT NULL";
        $P_SQL[] = "ALTER TABLE `{$_TABLES['pollanswers']}` ADD `qid` VARCHAR( 20 ) NOT NULL DEFAULT '0' AFTER `pid`;";
        $P_SQL[] = "ALTER TABLE `{$_TABLES['pollanswers']}` DROP PRIMARY KEY;";
        $P_SQL[] = "ALTER TABLE `{$_TABLES['pollanswers']}` ADD INDEX ( `qid` );";
        $P_SQL[] = "ALTER TABLE `{$_TABLES['pollanswers']}` ADD INDEX ( `aid` );";
        $P_SQL[] = "ALTER TABLE `{$_TABLES['pollanswers']}` ADD INDEX ( `pid` );";
        $P_SQL[] = "ALTER TABLE `{$_TABLES['pollvoters']}` CHANGE `qid` `pid` VARCHAR( 20 ) NOT NULL";
        $P_SQL[] = "CREATE TABLE {$_TABLES['pollquestions']} (
              qid mediumint(9) NOT NULL DEFAULT '0',
              pid varchar(20) NOT NULL,
              question varchar(255) NOT NULL,
              KEY `qid` (`qid`)
            ) TYPE=MyISAM
            ";
        $P_SQL = INST_checkInnodbUpgrade($P_SQL);
        for ($i = 0; $i < count ($P_SQL); $i++) {
            DB_query (current ($P_SQL));
            next ($P_SQL);
        }
        $P_SQL = array();
        $move_sql = "SELECT pid, topic FROM {$_TABLES['polltopics']}";
        $move_rst = DB_query ($move_sql);
        $count_move = DB_numRows($move_rst);
        for ($i=0; $i<$count_move; $i++) {
            $A = DB_fetchArray($move_rst);
            $P_SQL[] = "INSERT INTO {$_TABLES['pollquestions']} (pid, question) VALUES ('{$A[0]}','{$A[1]}');";
        }
        $P_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version = '2.0', pi_gl_version = '1.4.1' WHERE pi_name = 'polls'";
        //var_dump($P_SQL);
        for ($i = 0; $i < count ($P_SQL); $i++) {
            DB_query (current ($P_SQL));
            next ($P_SQL);
        }
    }
}

function upgrade_StaticpagesPlugin()
{
    global $_TABLES;

    // Polls plugin updates
    $check_sql = "SELECT pi_name FROM {$_TABLES['plugins']} WHERE pi_name = 'staticpages';";
    $check_rst = DB_query ($check_sql);
    if (DB_numRows($check_rst) == 1) {
        $P_SQL = array();
        $P_SQL[] = "ALTER TABLE `{$_TABLES['staticpage']}` ADD commentcode tinyint(4) NOT NULL default '0' AFTER sp_label";
        $P_SQL = INST_checkInnodbUpgrade($P_SQL);
        for ($i = 0; $i < count ($P_SQL); $i++) {
            DB_query (current ($P_SQL));
            next ($P_SQL);
        }
    }
}

function upgrade_LinksPlugin() {
    global $_TABLES, $_CONF;
    $check_sql = "SELECT pi_name FROM {$_TABLES['plugins']} WHERE pi_name = 'links';";
    $check_rst = DB_query ($check_sql);
    if (DB_numRows($check_rst) == 1) {
        include_once($_CONF['path'] . "/plugins/links/functions.inc");
        plugin_upgrade_links();
    }
}
?>
