<?php

$_SQL[] = "ALTER TABLE {$_TABLES['topics']} ADD is_default tinyint(1) unsigned NOT NULL DEFAULT '0'";

$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD pwrequestid varchar(16) DEFAULT NULL";

?>
