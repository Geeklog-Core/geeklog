<?php

$_SQL[] = "ALTER TABLE {$_TABLES['userprefs']} ADD emailfromadmin tinyint(1) NOT NULL DEFAULT '1'";
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD is_enabled tinyint(1) unsigned NOT NULL DEFAULT '1'";
$_SQL[] = "ALTER TABLE {$_TABLES['comments']} ADD type varchar(30) NOT NULL DEFAULT 'article'";
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD photo varchar(128) DEFAULT NULL";
$_SQL[] = "ALTER TABLE {$_TABLES['stories']} ADD show_topic_icon tinyint(1) unsigned NOT NULL DEFAULT '1'";

$_SQL[] ="
CREATE TABLE {$_TABLES['article_images']} (
  ai_sid varchar(20) NOT NULL,
  ai_img_num tinyint(2) unsigned NOT NULL,
  ai_filename varchar(128) NOT NULL,
  PRIMARY KEY (ai_sid,ai_img_num)
) TYPE=MyISAM
";
?>
