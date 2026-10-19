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
function DB_query($sql)
{
    $GLOBALS['queries'][] = $sql;
    if (strpos($sql, 'SHOW INDEX') === 0) {
        return 'index';
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
echo "PASS: Spam-X composite primary-key helper mock scenarios\n";
