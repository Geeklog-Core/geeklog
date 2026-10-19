<?php
/**
 * Disposable MariaDB integration test for Spam-X key migrations (#1151).
 * Requires SPAMX_DB_HOST, SPAMX_DB_USER, SPAMX_DB_PASSWORD, SPAMX_DB_NAME.
 * NEVER point this test at an existing database: it drops the gl_spamx_ci table.
 */
error_reporting(E_ALL);
foreach (array('SPAMX_DB_HOST', 'SPAMX_DB_USER', 'SPAMX_DB_PASSWORD', 'SPAMX_DB_NAME') as $key) {
    if (getenv($key) === false) {
        fwrite(STDERR, "Missing database test environment: {$key}\n");
        exit(2);
    }
}
// The legacy Geeklog DB API reports SQL errors as false in this test.
mysqli_report(MYSQLI_REPORT_OFF);
$db = new mysqli(getenv('SPAMX_DB_HOST'), getenv('SPAMX_DB_USER'), getenv('SPAMX_DB_PASSWORD'), getenv('SPAMX_DB_NAME'));
if ($db->connect_errno) {
    fwrite(STDERR, "Database connection failed\n");
    exit(2);
}
$db->set_charset('utf8mb4');
$_TABLES = array('spamx' => 'gl_spamx_ci');
function DB_query($sql) {
    global $db;
    return $db->query($sql);
}
function DB_fetchArray($result) {
    return $result->fetch_assoc();
}
function COM_errorLog($message, $level) {
    fwrite(STDERR, $message . "\n");
}
require_once __DIR__ . '/../plugins/spamx/sql/mysql_updates.php';

function fixture($key) {
    DB_query('DROP TABLE IF EXISTS gl_spamx_ci');
    $sql = 'CREATE TABLE gl_spamx_ci (name VARCHAR(20) NOT NULL, value VARCHAR(191) NOT NULL, counter INT NOT NULL DEFAULT 0, regdate DATETIME NULL';
    if ($key === 'name') {
        $sql .= ', PRIMARY KEY (name)';
    } elseif ($key === 'composite') {
        $sql .= ', PRIMARY KEY (name, value)';
    }
    $sql .= ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4';
    if (DB_query($sql) === false) {
        throw new Exception('Cannot prepare fixture');
    }
}
function assertRows($expected) {
    $result = DB_query('SELECT name, value FROM gl_spamx_ci ORDER BY name, value');
    if ($result === false || $result->num_rows !== $expected) {
        throw new Exception('Unexpected retained row count');
    }
}
function assertCompositeKey() {
    $result = DB_query("SHOW INDEX FROM gl_spamx_ci WHERE Key_name = 'PRIMARY'");
    $cols = array();
    while ($row = DB_fetchArray($result)) {
        $cols[(int) $row['Seq_in_index']] = $row['Column_name'];
    }
    ksort($cols);
    if (array_values($cols) !== array('name', 'value')) {
        throw new Exception('Composite primary key not present');
    }
}
try {
    // Legacy no-key table permits multiple rules with same name.
    fixture('none');
    DB_query("INSERT INTO gl_spamx_ci (name,value) VALUES ('Personal','rule-a'),('Personal','rule-b')");
    if (!spamx_upgradeMysqlPrimaryKey()) throw new Exception('no-key upgrade failed');
    assertCompositeKey();
    assertRows(2);
    // Repeat must be idempotent.
    if (!spamx_upgradeMysqlPrimaryKey()) throw new Exception('repeat upgrade failed');
    assertRows(2);

    // Already-correct schema: keep data unchanged.
    fixture('composite');
    DB_query("INSERT INTO gl_spamx_ci (name,value) VALUES ('IP','10.0.0.1')");
    if (!spamx_upgradeMysqlPrimaryKey()) throw new Exception('existing composite failed');
    assertCompositeKey();
    assertRows(1);

    // Historical name-only schema: atomic replacement, rows survive.
    fixture('name');
    DB_query("INSERT INTO gl_spamx_ci (name,value) VALUES ('Personal','rule-a'),('IP','10.0.0.1')");
    if (!spamx_upgradeMysqlPrimaryKey()) throw new Exception('name-only upgrade failed');
    assertCompositeKey();
    assertRows(2);

    // Duplicate composite values must not silently disappear.
    fixture('none');
    DB_query("INSERT INTO gl_spamx_ci (name,value) VALUES ('Personal','duplicate'),('Personal','duplicate')");
    if (spamx_upgradeMysqlPrimaryKey()) throw new Exception('duplicate rows unexpectedly accepted');
    assertRows(2);

    echo "PASS: MariaDB Spam-X primary-key migration fixtures\n";
} catch (Exception $e) {
    fwrite(STDERR, "FAIL: " . $e->getMessage() . "\n");
    exit(1);
} finally {
    DB_query('DROP TABLE IF EXISTS gl_spamx_ci');
}
