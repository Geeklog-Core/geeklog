<?php

$_SQL[] = "ALTER TABLE {$_TABLES['stories']} DROP INDEX stories_in_transit";
$_SQL[] = "ALTER TABLE {$_TABLES['stories']} DROP COLUMN in_transit";

function update_ConfValues()
{
    global $_CONF;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    // new option
    $c->add('jpeg_quality',75,'text',5,23,NULL,1495,FALSE);

    return true;
}

?>
