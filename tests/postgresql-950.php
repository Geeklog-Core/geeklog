<?php
// Isolated PostgreSQL smoke audit: use a disposable database only.
require __DIR__ . '/../public_html/admin/install/classes/db.class.php';

if (!extension_loaded('pgsql')) {
    fwrite(STDERR, "FAIL: PHP pgsql extension required\n");
    exit(1);
}
$args = array(
    'host' => getenv('PGHOST') ?: '127.0.0.1',
    'name' => getenv('PGDATABASE') ?: 'geeklog_test950',
    'user' => getenv('PGUSER') ?: 'geeklog',
    'pass' => getenv('PGPASSWORD') ?: '',
    'charset' => 'UTF8',
);
if ($args['name'] !== 'geeklog_test950') {
    fwrite(STDERR, "FAIL: use the dedicated geeklog_test950 database\n");
    exit(1);
}
$db = \Geeklog\Db::connect(\Geeklog\Db::DB_POSTGRES, $args);
if (!$db) {
    fwrite(STDERR, "FAIL: installer PostgreSQL driver connection\n");
    exit(1);
}
echo "OK: installer PostgreSQL driver connects\n";
function run950($db, $sql, $label)
{
    $result = @$db->query($sql);
    if ($result === false) {
        throw new RuntimeException($label . ': ' . $db->error());
    }
    return $result;
}
$failed = false;
try {
    run950($db, 'BEGIN', 'begin transaction');
    run950($db, 'CREATE SCHEMA gl950_smoke', 'create isolated schema');
    run950($db, 'SET LOCAL search_path TO gl950_smoke', 'set search path');
    run950($db, 'CREATE TABLE smoke (id integer PRIMARY KEY, value text)', 'create table');
    run950($db, "INSERT INTO smoke VALUES (1, 'test')", 'insert');
    run950($db, "UPDATE smoke SET value = 'updated' WHERE id = 1", 'update');
    $result = run950($db, 'SELECT value FROM smoke WHERE id = 1', 'select');
    if (pg_fetch_result($result, 0, 0) !== 'updated') {
        throw new RuntimeException('CRUD select mismatch');
    }
    run950($db, 'DELETE FROM smoke WHERE id = 1', 'delete');
    if (pg_fetch_result(run950($db, 'SELECT count(*) FROM smoke', 'count'), 0, 0) !== '0') {
        throw new RuntimeException('CRUD delete mismatch');
    }
    echo "OK: PostgreSQL CRUD\n";

    // Reuse the actual Core table names without bootstrapping a live site.
    $mapping = file_get_contents(__DIR__ . '/../system/lib-database.php');
    preg_match_all('/\$_TABLES\[\x27([^\x27]+)\x27\]\s*=\s*\$_DB_table_prefix\s*\.\s*\x27([^\x27]+)\x27/', $mapping, $matches, PREG_SET_ORDER);
    $_TABLES = array();
    foreach ($matches as $match) {
        $_TABLES[$match[1]] = 'gl_' . $match[2];
    }
    $_SQL = array();
    $_DATA = array();
    require __DIR__ . '/../sql/pgsql_tableanddata.php';
    foreach ($_SQL as $i => $sql) {
        run950($db, $sql, 'Core schema statement ' . ($i + 1));
    }
    echo 'OK: Core schema (' . count($_SQL) . " statements)\n";
    foreach ($_DATA as $i => $sql) {
        run950($db, $sql, 'Core seed statement ' . ($i + 1));
    }
    echo 'OK: Core initial data (' . count($_DATA) . " statements)\n";
} catch (Exception $error) {
    fwrite(STDERR, 'FAIL: ' . $error->getMessage() . PHP_EOL);
    $failed = true;
}
$db->query('ROLLBACK');
$db->close();
exit($failed ? 1 : 0);
