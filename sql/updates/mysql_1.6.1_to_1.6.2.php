<?php

// make $_CONF['menu_elements'] and $_CONF['notification'] arrays of dropdowns
$_SQL[] = "UPDATE {$_TABLES['conf_values']} SET type = '%select', selectionArray = 24 WHERE name = 'menu_elements' AND group_name = 'Core'";
$_SQL[] = "UPDATE {$_TABLES['conf_values']} SET type = '%select', selectionArray = 25 WHERE name = 'notification' AND group_name = 'Core'";

// make $_CONF['default_perm_cookie_timeout'] option a dropdown
$_SQL[] = "UPDATE {$_TABLES['conf_values']} SET type = 'select' WHERE name = 'default_perm_cookie_timeout' AND group_name = 'Core'";

// make $_CONF['gravatar_rating'] option a dropdown
$_SQL[] = "UPDATE {$_TABLES['conf_values']} SET type = 'select', selectionArray = 26 WHERE name = 'gravatar_rating' AND group_name = 'Core'";

// change some config options to use a textarea instead of a one-line text field
$_SQL[] = "UPDATE {$_TABLES['conf_values']} SET type = 'textarea' WHERE name = 'site_disabled_msg' AND group_name = 'Core'";
$_SQL[] = "UPDATE {$_TABLES['conf_values']} SET type = 'textarea' WHERE name = 'meta_description' AND group_name = 'Core'";
$_SQL[] = "UPDATE {$_TABLES['conf_values']} SET type = 'textarea' WHERE name = 'meta_keywords' AND group_name = 'Core'";

// make room to store IPv6 addresses
$_SQL[] = "ALTER TABLE {$_TABLES['comments']} CHANGE ipaddress ipaddress varchar(39) NOT NULL default ''";
$_SQL[] = "ALTER TABLE {$_TABLES['commentsubmissions']} CHANGE ipaddress ipaddress varchar(39) NOT NULL default ''";
$_SQL[] = "ALTER TABLE {$_TABLES['sessions']} CHANGE remote_ip remote_ip varchar(39) NOT NULL default ''";
$_SQL[] = "ALTER TABLE {$_TABLES['speedlimit']} CHANGE ipaddress ipaddress varchar(39) NOT NULL default ''";
$_SQL[] = "ALTER TABLE {$_TABLES['trackback']} CHANGE ipaddress ipaddress varchar(39) NOT NULL default ''";

// new "Default Group" flag
$_SQL[] = "ALTER TABLE {$_TABLES['groups']} ADD grp_default tinyint(1) unsigned NOT NULL default '0' AFTER grp_gl_core";

// allow users to choose whether they want to use the Advanced Editor or not
$_SQL[] = "ALTER TABLE {$_TABLES['userprefs']} ADD advanced_editor tinyint(1) unsigned NOT NULL default '1' AFTER dfid";
$_SQL[] = "UPDATE {$_TABLES['userprefs']} SET advanced_editor = 0 WHERE uid = 1";

?>
