<?php

function update_ConfValues()
{
    global $_CONF;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    // new option
    $c->add('jpeg_quality',75,'text',5,23,NULL,1495,FALSE);

    return true;
}

function upgrade_PollsPluginId()
{
    global $_TABLES;

    $P_SQL = array();
    $P_SQL[] = "ALTER TABLE {$_TABLES['pollanswers']} ALTER COLUMN [pid] VARCHARS(40)";
    $P_SQL[] = "ALTER TABLE {$_TABLES['pollquestions']} ALTER COLUMN [pid] VARCHARS(40)";
    $P_SQL[] = "ALTER TABLE {$_TABLES['polltopics']} ALTER COLUMN [pid] VARCHARS(40)";
    $P_SQL[] = "ALTER TABLE {$_TABLES['pollvoters']} ALTER COLUMN [pid] VARCHARS(40)";

    foreach ($P_SQL as $sql) {
        $rst = DB_query($sql);
        if (DB_error()) {
            echo "There was an error upgrading the polls, SQL: $sql<br>";
            return false;
        }
    }

    return true;
}

?>
