<?php

$_SQL[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('database_version', '0.0.0')";
$_SQL[] = "UPDATE {$_TABLES['syndication']} SET type = 'article' WHERE type = 'geeklog'";
$_SQL[] = "UPDATE {$_TABLES['syndication']} SET type = 'article' WHERE type = 'glfusion'";

?>
