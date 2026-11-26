<?php
// PostgreSQL regression test for the Likes index upgrade (#1177).
error_reporting(E_ALL);
set_error_handler(function ($severity, $message) {
    throw new RuntimeException($message);
});
$conn = pg_connect('host=' . getenv('PGHOST') . ' dbname=' . getenv('PGDATABASE')
    . ' user=' . getenv('PGUSER') . ' password=' . getenv('PGPASSWORD'));
if (!$conn) {
    throw new RuntimeException('PostgreSQL connection failed');
}
function DB_query($sql)
{
    global $conn;
    $result = pg_query($conn, $sql);
    if ($result === false) {
        throw new RuntimeException(pg_last_error($conn));
    }
    return $result;
}
function DB_numRows($result)
{
    return pg_num_rows($result);
}
function check1177($condition, $label)
{
    if (!$condition) {
        throw new RuntimeException('FAIL: ' . $label);
    }
    echo "OK: $label\n";
}
function run1177Migration()
{
    global $_TABLES;
    $_SQL = array();
    require __DIR__ . '/../sql/updates/pgsql_2.2.2_to_2.2.3.php';
    foreach ($_SQL as $sql) {
        DB_query($sql);
    }
    return count($_SQL);
}
$_TABLES = array('likes' => 'likes_1177');
DB_query('BEGIN');
try {
    DB_query('CREATE TEMPORARY TABLE likes_1177 (lid INT PRIMARY KEY, created TIMESTAMP NOT NULL)');
    DB_query("INSERT INTO likes_1177 VALUES (1, '2020-01-01')");
    check1177(run1177Migration() === 1, 'Index created');
    check1177(DB_numRows(DB_query("SELECT 1 FROM pg_index i JOIN pg_class c ON c.oid=i.indexrelid WHERE i.indrelid='likes_1177'::regclass AND c.relname='likes_1177_created'")) === 1, 'Index exists');
    check1177(run1177Migration() === 0, 'Migration can be repeated');
    DB_query('DROP INDEX likes_1177_created');
    DB_query('CREATE INDEX manual_created ON likes_1177 (created, lid)');
    check1177(run1177Migration() === 0, 'Existing manual index preserved');
    DB_query('DROP INDEX manual_created');
    DB_query('CREATE INDEX partial_created ON likes_1177 (created) WHERE lid > 1');
    check1177(run1177Migration() === 1, 'Partial index does not replace complete index');
    check1177(DB_numRows(DB_query('SELECT * FROM likes_1177')) === 1, 'Existing data preserved');
    echo "TOTAL: 6/6 checks passed\n";
} finally {
    DB_query('ROLLBACK');
}
