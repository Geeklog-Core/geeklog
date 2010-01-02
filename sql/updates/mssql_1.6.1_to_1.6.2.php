<?php

// make $_CONF['menu_elements'] and $_CONF['notification'] arrays of dropdowns
$_SQL[] = "UPDATE {$_TABLES['conf_values']} SET type = '%select', selectionArray = 24 WHERE name = 'menu_elements' AND group_name = 'Core'";
$_SQL[] = "UPDATE {$_TABLES['conf_values']} SET type = '%select', selectionArray = 25 WHERE name = 'notification' AND group_name = 'Core'";

// make $_CONF['default_perm_cookie_timeout'] option a dropdown
$_SQL[] = "UPDATE {$_TABLES['conf_values']} SET type = 'select' WHERE name = 'default_perm_cookie_timeout' AND group_name = 'Core'";

// make room to store IPv6 addresses
$_SQL[] = "ALTER TABLE {$_TABLES['comments']} ALTER COLUMN [ipaddress] varchar(39) NOT NULL";
$_SQL[] = "ALTER TABLE {$_TABLES['commentsubmissions']} ALTER COLUMN [ipaddress] varchar(39) NOT NULL";
$_SQL[] = "ALTER TABLE {$_TABLES['sessions']} ALTER COLUMN [remote_ip] varchar(39) NOT NULL";
$_SQL[] = "ALTER TABLE {$_TABLES['speedlimit']} ALTER COLUMN [ipaddress] varchar(39) NOT NULL";
$_SQL[] = "ALTER TABLE {$_TABLES['trackback']} ALTER COLUMN [ipaddress] varchar(39) NOT NULL";

// new "Default Group" flag
$_SQL[] = "ALTER TABLE {$_TABLES['groups']} ADD [grp_default] [tinyint] NOT NULL";

?>
