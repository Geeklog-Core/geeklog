<?php
/**
 * Spam-X full upgrade dispatcher regression, with a disposable in-memory SQL
 * adapter and production function body extracted unchanged from functions.inc.
 * Run: php tests/spamx-dispatcher-1151.php
 *
 * The test removes only bootstrap require_once statements from the extracted
 * function (dependencies below are mocked). No production DB is modified.
 */
error_reporting(E_ALL);
$_SERVER['PHP_SELF'] = 'spamx-dispatcher-1151.php';
$_TABLES = array('plugins' => 'gl_plugins', 'spamx' => 'gl_spamx');
$_CONF = array('path' => dirname(__DIR__) . '/');
$_DB_dbms = 'mysql';
$GLOBALS['plugin_version'] = '1.3.3';
$GLOBALS['query_fail'] = '';
$GLOBALS['sql_calls'] = array();
$GLOBALS['long_values'] = false;
$GLOBALS['key_columns'] = array('name', 'value');
function DB_getItem($table, $field, $where) { return $GLOBALS['plugin_version']; }
function plugin_chkVersion_spamx() { return '1.3.6'; }
function plugin_compatible_with_this_version_spamx($name) { return true; }
function COM_errorLog($message, $level = 1) {}
function DB_numRows($result) { return $result === 'rows' ? 1 : 0; }
function DB_fetchArray($result) {
    if ($result === 'index') {
        if (empty($GLOBALS['key_columns'])) return false;
        $column = array_shift($GLOBALS['key_columns']);
        $n = !isset($GLOBALS['key_seq']) ? 1 : ++$GLOBALS['key_seq'];
        return array('Seq_in_index' => $n, 'Column_name' => $column);
    }
    return false;
}
function DB_query($sql) {
    $GLOBALS['sql_calls'][] = $sql;
    if ($GLOBALS['query_fail'] !== '' && strpos($sql, $GLOBALS['query_fail']) !== false) return false;
    if (strpos($sql, 'SHOW INDEX') === 0) return 'index';
    if (strpos($sql, 'CHAR_LENGTH(value) > 191') !== false) return $GLOBALS['long_values'] ? 'rows' : 'empty';
    if (strpos($sql, 'GROUP BY name, LEFT(value, 191)') !== false) return 'empty';
    if (strpos($sql, "UPDATE gl_plugins SET pi_version = '1.3.6'") === 0) $GLOBALS['plugin_version'] = '1.3.6';
    return true;
}
function spamx_update_ConfValues_1_3_4() { return true; }

// Extract and execute production dispatcher without loading unrelated Geeklog
// top-level bootstrap; only the require_once lines are removed.
$source = file_get_contents(__DIR__ . '/../plugins/spamx/functions.inc');
$begin = strpos($source, 'function plugin_upgrade_spamx()');
$end = strpos($source, '/**', $begin);
if ($begin === false || $end === false) { fwrite(STDERR, "Unable to locate upgrade function\n"); exit(2); }
$function = substr($source, $begin, $end - $begin);
$function = preg_replace('/^\s*require_once .*?;\s*$/m', "\n", $function);
eval($function);
// Config metadata from actual autoinstall is not relevant to versioned SQL.
function plugin_autoinstall_spamx($name) {
    return array('info' => array('pi_gl_version' => '2.2.2', 'pi_homepage' => 'https://example.com'));
}
$_UPDATES = array();
require __DIR__ . '/../plugins/spamx/sql/mysql_updates.php';

function scenario($version, $failure, $expectedReturn, $expectedVersion) {
    $GLOBALS['plugin_version'] = $version;
    $GLOBALS['query_fail'] = $failure;
    $GLOBALS['sql_calls'] = array();
    $GLOBALS['key_columns'] = array('name', 'value');
    unset($GLOBALS['key_seq']);
    $GLOBALS['long_values'] = false;
    $value = plugin_upgrade_spamx();
    if ($value !== $expectedReturn || $GLOBALS['plugin_version'] !== $expectedVersion) {
        fwrite(STDERR, "FAIL: start={$version}, failed={$failure}, version={$GLOBALS['plugin_version']}\n");
        exit(1);
    }
}
scenario('1.3.3', '', true, '1.3.6');
scenario('1.3.3', 'MODIFY COLUMN', false, '1.3.3');
scenario('1.3.3', "UPDATE gl_plugins SET pi_version", false, '1.3.3');
scenario('1.3.2', 'MODIFY COLUMN regdate', false, '1.3.2');
scenario('1.3.1', '', true, '1.3.6');
echo "PASS: Spam-X full dispatcher success and SQL failure scenarios\n";
