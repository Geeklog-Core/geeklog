<?php

$_SQL[] = "RENAME TABLE staticpage TO {$_TABLES['staticpage']}";
$_SQL[] = "DELETE FROM {$_TABLES['commentcodes']} WHERE code = 1";

?>
