<?php

function update_ConfValues()
{
    global $_CONF;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    // new option
    $c->add('jpeg_quality',75,'text',5,23,NULL,1495,FALSE);

    if (INST_pluginExists('links')) {
        $c->add('new_window',false,'select',0,0,1,55,TRUE,'links');
    }

    return true;
}

function upgrade_PollsPluginId()
{
    global $_TABLES;

    $P_SQL = array();
    $P_SQL[] = "ALTER TABLE {$_TABLES['pollanswers']} CHANGE pid pid varchar(40) NOT NULL default ''";
    $P_SQL[] = "ALTER TABLE {$_TABLES['pollquestions']} CHANGE pid pid varchar(40) NOT NULL default ''";
    $P_SQL[] = "ALTER TABLE {$_TABLES['polltopics']} CHANGE pid pid varchar(40) NOT NULL default ''";
    $P_SQL[] = "ALTER TABLE {$_TABLES['pollvoters']} CHANGE pid pid varchar(40) NOT NULL default ''";

    $P_SQL = INST_checkInnodbUpgrade($P_SQL);
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
