<?php

// Create "routes" table
$_SQL[] = "CREATE TABLE {$_TABLES['routes']} (
    rid SERIAL,
    method int NOT NULL DEFAULT 1,
    rule varchar(255) NOT NULL DEFAULT '',
    route varchar(255) NOT NULL DEFAULT '',
    priority int NOT NULL DEFAULT 100,
    PRIMARY KEY (rid)
)";

// Add sample routes to the table
$_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route) VALUES (1, '/article/@sid', '/article.php?story=@sid')";
$_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route) VALUES (1, '/topic/@topic', '/index.php?topic=@topic')";
$_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route) VALUES (1, '/page/@page', '/staticpages/index.php?page=@page')";

/**
 * Add new config options
 *
 */
function update_ConfValuesFor212()
{
    global $_CONF;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();
    $me = 'Core';
    $c->add('url_routing',FALSE,'select',0,0,36,1850,TRUE, $me, 0);

    return true;
}
