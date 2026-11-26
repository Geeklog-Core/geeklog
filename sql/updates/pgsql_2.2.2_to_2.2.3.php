<?php

// Accept an existing valid, non-partial B-tree index starting with created.
$result = DB_query("SELECT 1 FROM pg_index i
    JOIN pg_class c ON c.oid = i.indexrelid
    JOIN pg_am am ON am.oid = c.relam
    JOIN pg_attribute a ON a.attrelid = i.indrelid AND a.attnum = i.indkey[0]
    WHERE i.indrelid = '{$_TABLES['likes']}'::regclass
      AND a.attname = 'created' AND am.amname = 'btree'
      AND i.indisvalid AND i.indpred IS NULL
    LIMIT 1");
if (DB_numRows($result) === 0) {
    $_SQL[] = "CREATE INDEX {$_TABLES['likes']}_created ON {$_TABLES['likes']} (created)";
}
