<?php

// make $_CONF['menu_elements'] and $_CONF['notification'] arrays of dropdowns
$_SQL[] = "UPDATE {$_TABLES['conf_values']} SET type = '%select', selectionArray = 24 WHERE name = 'menu_elements' AND group_name = 'Core'";
$_SQL[] = "UPDATE {$_TABLES['conf_values']} SET type = '%select', selectionArray = 25 WHERE name = 'notification' AND group_name = 'Core'";

// make room to store IPv6 addresses
$_SQL[] = "ALTER TABLE {$_TABLES['comments']} CHANGE ipaddress ipaddress varchar(39) NOT NULL default ''";
$_SQL[] = "ALTER TABLE {$_TABLES['commentsubmissions']} CHANGE ipaddress ipaddress varchar(39) NOT NULL default ''";
$_SQL[] = "ALTER TABLE {$_TABLES['sessions']} CHANGE remote_ip remote_ip varchar(39) NOT NULL default ''";
$_SQL[] = "ALTER TABLE {$_TABLES['speedlimit']} CHANGE ipaddress ipaddress varchar(39) NOT NULL default ''";
$_SQL[] = "ALTER TABLE {$_TABLES['trackback']} CHANGE ipaddress ipaddress varchar(39) NOT NULL default ''";

?>
