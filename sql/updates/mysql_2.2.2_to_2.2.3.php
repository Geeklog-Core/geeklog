<?php

// A site may already have a suitable index from the workaround for #1177.
$result = DB_query("SHOW INDEX FROM {$_TABLES['likes']}");
$hasCreatedIndex = false;
while ($row = DB_fetchArray($result)) {
    if ((int) $row['Seq_in_index'] === 1 &&
        strtolower($row['Column_name']) === 'created' &&
        strtoupper($row['Index_type']) === 'BTREE') {
        $hasCreatedIndex = true;
        break;
    }
}
if (!$hasCreatedIndex) {
    $_SQL[] = "ALTER TABLE {$_TABLES['likes']} ADD INDEX created (created)";
}
