<?php

// bugfix: allow up to 40 characters for the story ID
$_SQL[] = "ALTER TABLE {$_TABLES['comments']} CHANGE sid sid varchar(40) NOT NULL default ''";

?>
