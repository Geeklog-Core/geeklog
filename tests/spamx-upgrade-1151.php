<?php
/**
 * Isolated regression checks for Spam-X primary-key migration (#1151).
 * Run: php tests/spamx-upgrade-1151.php
 * No database is modified; DB calls are mocked.
 */
error_reporting(E_ALL);
$_TABLES = array('spamx' => 'gl_spamx');
$_SERVER['PHP_SELF'] = 'spamx-upgrade-1151.php';
$GLOBALS['index_columns'] = array();
$GLOBALS['queries'] = array();
$GLOBALS['fail_alter'] = false;
$GLOBALS['fail_index'] = false;
function DB_query($sql)
{
    $GLOBALS['queries'][] = $sql;
    if (strpos($sql, 'SHOW INDEX') === 0) {
        return $GLOBALS['fail_index'] ? false : 'index';
    }
    return $GLOBALS['fail_alter'] ? false : true;
}
function DB_fetchArray($result)
{
    if ($result !== 'index' || count($GLOBALS['index_columns']) === 0) {
        return false;
    }
    $column = array_shift($GLOBALS['index_columns']);
    return array('Seq_in_index' => $column[0], 'Column_name' => $column[1]);
}
function COM_errorLog($message, $level)
{
    return true;
}
require_once __DIR__ . '/../plugins/spamx/sql/mysql_updates.php';

$cases = array(
    array(array(array(1, 'name'), array(2, 'value')), true, 0),
    array(array(), true, 1),
    array(array(array(1, 'name')), true, 1),
    array(array(array(1, 'other')), false, 0)
);
foreach ($cases as $index => $case) {
    $GLOBALS['index_columns'] = $case[0];
    $GLOBALS['queries'] = array();
    $GLOBALS['fail_alter'] = false;
    $GLOBALS['fail_index'] = false;
    $actual = spamx_upgradeMysqlPrimaryKey();
    $alters = array_filter($GLOBALS['queries'], function ($sql) {
        return strpos($sql, 'ALTER TABLE') === 0;
    });
    if ($actual !== $case[1] || count($alters) !== $case[2]) {
        fwrite(STDERR, "FAIL case {$index}\n");
        exit(1);
    }
}
$GLOBALS['index_columns'] = array(array(1, 'name'));
$GLOBALS['queries'] = array();
$GLOBALS['fail_alter'] = true;
if (spamx_upgradeMysqlPrimaryKey() !== false) {
    fwrite(STDERR, "FAIL SQL error case\n");
    exit(1);
}

// Check that replacement is one combined DDL statement and never two DDLs.
$GLOBALS['index_columns'] = array(array(1, 'name'));
$GLOBALS['queries'] = array();
$GLOBALS['fail_alter'] = false;
if (spamx_upgradeMysqlPrimaryKey() !== true) {
    fwrite(STDERR, "FAIL combined ALTER case\n");
    exit(1);
}
$ddl = array_values(array_filter($GLOBALS['queries'], function ($sql) {
    return strpos($sql, 'ALTER TABLE') === 0;
}));
if (count($ddl) !== 1 || strpos($ddl[0], 'DROP PRIMARY KEY, ADD PRIMARY KEY (name, value)') === false) {
    fwrite(STDERR, "FAIL expected one combined ALTER TABLE\n");
    exit(1);
}
// An index introspection error must stop before any schema change.
$GLOBALS['fail_index'] = true;
$GLOBALS['queries'] = array();
if (spamx_upgradeMysqlPrimaryKey() !== false || count($GLOBALS['queries']) !== 1) {
    fwrite(STDERR, "FAIL index read error case\n");
    exit(1);
}
$GLOBALS['fail_index'] = false;
echo "PASS: Spam-X composite primary-key helper mock scenarios\n";
