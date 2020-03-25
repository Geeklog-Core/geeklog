<?php

require_once __DIR__ . '/lib-common.php';
require_once $_CONF['path_system'] . 'classes/config.class.php';

$c = config::get_instance();

/*
$me = 'Core';

// $c->add('cache_mobile',TRUE,'select',2,10,1,230,TRUE, $me, 10);

$c->add('google_login',0,'select',4,16,1,359,TRUE, $me, 16);
$c->add('google_consumer_key','','text',4,16,NULL,360,TRUE, $me, 16);
$c->add('google_consumer_secret','','text',4,16,NULL,361,TRUE, $me, 16); 

*/

$n = 'forum';
$o = 59;
$t = 0;

// Add Likes System config value
$c->add('likes_forum', 1,           'select',   0, 0, 41,   $o, true, $n, $t);

   

echo "Config Updated.";
