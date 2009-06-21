<?php

// There weren't any database changes in Geeklog 1.5.2, but all the plugins
// had bugfixes, so let's increase their version numbers ...

$_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version = '1.0.3', pi_gl_version = '1.5.0' WHERE pi_name = 'calendar'";
$_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version = '2.0.1', pi_gl_version = '1.5.0' WHERE pi_name = 'links'";
$_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version = '2.0.2', pi_gl_version = '1.5.0' WHERE pi_name = 'polls'";
$_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version = '1.1.2', pi_gl_version = '1.5.0' WHERE pi_name = 'spamx'";
$_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version = '1.5.1', pi_gl_version = '1.5.0' WHERE pi_name = 'staticpages'";

?>
