<?php
/**
 * SQL-backed Spam-X dispatcher regression, using the production function body.
 * Run only against a disposable CI database. Drops gl_spamx_ci and gl_plugins_ci.
 */
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_OFF);
$db = new mysqli(getenv('SPAMX_DB_HOST'), getenv('SPAMX_DB_USER'), getenv('SPAMX_DB_PASSWORD'), getenv('SPAMX_DB_NAME'));
if ($db->connect_errno) { fwrite(STDERR, "DB connection failed\n"); exit(2); }
$db->set_charset('utf8mb4');
$_TABLES = array('spamx'=>'gl_spamx_ci','plugins'=>'gl_plugins_ci','features'=>'gl_features_ci');
$_CONF = array('path'=>dirname(__DIR__).'/');
$_DB_dbms = 'mysql';
function DB_query($sql) { global $db; return $db->query($sql); }
function DB_numRows($result) { return $result->num_rows; }
function DB_fetchArray($result) { return $result->fetch_assoc(); }
function DB_getItem($table,$field,$where) {
    $result = DB_query("SELECT $field FROM $table WHERE $where");
    $row = DB_fetchArray($result);
    return $row[$field];
}
function COM_errorLog($message,$level=1) { fwrite(STDERR, $message."\n"); }
function plugin_chkVersion_spamx() { return '1.3.6'; }
function plugin_compatible_with_this_version_spamx($name) { return true; }
function plugin_autoinstall_spamx($name) { return array('info'=>array('pi_gl_version'=>'2.2.2','pi_homepage'=>'https://example.com')); }
function spamx_update_ConfValues_1_3_4() { return true; }
function spamx_update_ConfValues_1_3_0() { return true; }
$source = file_get_contents(__DIR__.'/../plugins/spamx/functions.inc');
$begin = strpos($source,'function plugin_upgrade_spamx()');
$end = strpos($source,'/**',$begin);
if ($begin===false || $end===false) exit(2);
$function = substr($source,$begin,$end-$begin);
$function = preg_replace('/^\\s*require_once .*?;\\s*$/m',"\n",$function);
$function = str_replace('global $_CONF, $_TABLES, $_DB_dbms;', 'global $_CONF, $_TABLES, $_DB_dbms, $_UPDATES;', $function);
eval($function);
require __DIR__.'/../plugins/spamx/sql/mysql_updates.php';
try {
    DB_query('DROP TABLE IF EXISTS gl_spamx_ci');
    DB_query('DROP TABLE IF EXISTS gl_plugins_ci');
    if (!DB_query("CREATE TABLE gl_spamx_ci (name VARCHAR(20) NOT NULL, value VARCHAR(255) NOT NULL, counter INT NOT NULL DEFAULT 0, regdate DATETIME NULL, PRIMARY KEY(name,value)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4")) throw new Exception('schema');
    if (!DB_query("CREATE TABLE gl_plugins_ci (pi_name VARCHAR(40) PRIMARY KEY, pi_version VARCHAR(20), pi_gl_version VARCHAR(20), pi_homepage VARCHAR(255)) ENGINE=InnoDB")) throw new Exception('plugin schema');
    DB_query("INSERT INTO gl_plugins_ci VALUES ('spamx','1.3.3','2.1.3','')");
    DB_query("INSERT INTO gl_spamx_ci(name,value) VALUES ('Personal','one'),('Personal','two')");
    if (plugin_upgrade_spamx() !== true) throw new Exception('dispatcher returned failure');
    if (DB_getItem('gl_plugins_ci','pi_version',"pi_name='spamx'") !== '1.3.6') throw new Exception('version not advanced');
    $count = DB_query("SELECT COUNT(*) AS n FROM gl_spamx_ci");
    if ((int) DB_fetchArray($count)['n'] !== 2) throw new Exception('rules lost');
    // Failed migration must not advance version.
    DB_query("UPDATE gl_plugins_ci SET pi_version='1.3.3' WHERE pi_name='spamx'");
    DB_query("ALTER TABLE gl_spamx_ci MODIFY value VARCHAR(255)");
    $long = str_repeat('z',192);
    $safe = $db->real_escape_string($long);
    DB_query("INSERT INTO gl_spamx_ci(name,value) VALUES ('Personal','$safe')");
    if (plugin_upgrade_spamx() !== false) throw new Exception('long value allowed');
    if (DB_getItem('gl_plugins_ci','pi_version',"pi_name='spamx'") !== '1.3.3') throw new Exception('version changed on failure');
    $count = DB_query("SELECT COUNT(*) AS n FROM gl_spamx_ci");
    if ((int) DB_fetchArray($count)['n'] !== 3) throw new Exception('rules lost on failure');
    // Historical 1.3.2: start with a name-only primary key.
    DB_query('DROP TABLE gl_spamx_ci');
    DB_query("CREATE TABLE gl_spamx_ci (name VARCHAR(20) NOT NULL, value VARCHAR(255) NOT NULL, counter INT NOT NULL DEFAULT 0, regdate DATETIME NULL, PRIMARY KEY(name)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    DB_query("UPDATE gl_plugins_ci SET pi_version='1.3.2' WHERE pi_name='spamx'");
    DB_query("INSERT INTO gl_spamx_ci(name,value) VALUES ('Personal','rule-a'),('IP','rule-b')");
    if (plugin_upgrade_spamx() !== true) throw new Exception('1.3.2 upgrade failed');
    if (DB_getItem('gl_plugins_ci','pi_version',"pi_name='spamx'") !== '1.3.6') throw new Exception('1.3.2 version');
    $idx = DB_query("SHOW INDEX FROM gl_spamx_ci WHERE Key_name='PRIMARY'");
    $cols = array();
    while ($row = DB_fetchArray($idx)) $cols[(int)$row['Seq_in_index']] = $row['Column_name'];
    ksort($cols);
    if (array_values($cols) !== array('name','value')) throw new Exception('1.3.2 composite key');
    $count = DB_query('SELECT COUNT(*) AS n FROM gl_spamx_ci');
    if ((int)DB_fetchArray($count)['n'] !== 2) throw new Exception('1.3.2 rules lost');

    // Historical 1.3.1: table without primary key, repeated rule names.
    DB_query('DROP TABLE gl_spamx_ci');
    DB_query("CREATE TABLE gl_spamx_ci (name VARCHAR(20) NOT NULL, value VARCHAR(255) NOT NULL, counter INT NOT NULL DEFAULT 0, regdate DATETIME NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    DB_query("UPDATE gl_plugins_ci SET pi_version='1.3.1' WHERE pi_name='spamx'");
    DB_query("INSERT INTO gl_spamx_ci(name,value) VALUES ('Personal','rule-a'),('Personal','rule-b')");
    if (plugin_upgrade_spamx() !== true) throw new Exception('1.3.1 upgrade failed');
    $count = DB_query('SELECT COUNT(*) AS n FROM gl_spamx_ci');
    if ((int)DB_fetchArray($count)['n'] !== 2) throw new Exception('1.3.1 rules lost');
    if (DB_getItem('gl_plugins_ci','pi_version',"pi_name='spamx'") !== '1.3.6') throw new Exception('1.3.1 version');

    // Historical 1.3.0: add counter and regdate to the original two-column table.
    DB_query('DROP TABLE gl_spamx_ci');
    DB_query("CREATE TABLE gl_spamx_ci (name VARCHAR(20) NOT NULL, value VARCHAR(255) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    DB_query("UPDATE gl_plugins_ci SET pi_version='1.3.0' WHERE pi_name='spamx'");
    DB_query("INSERT INTO gl_spamx_ci(name,value) VALUES ('Personal','rule-a'),('Personal','rule-b')");
    if (plugin_upgrade_spamx() !== true) throw new Exception('1.3.0 upgrade failed');
    if (DB_getItem('gl_plugins_ci','pi_version',"pi_name='spamx'") !== '1.3.6') throw new Exception('1.3.0 version');
    $count = DB_query('SELECT COUNT(*) AS n FROM gl_spamx_ci');
    if ((int)DB_fetchArray($count)['n'] !== 2) throw new Exception('1.3.0 rules lost');
    $cols = DB_query("SHOW COLUMNS FROM gl_spamx_ci");
    $columnNames = array();
    while ($row = DB_fetchArray($cols)) $columnNames[] = $row['Field'];
    if (!in_array('counter',$columnNames) || !in_array('regdate',$columnNames)) throw new Exception('1.3.0 missing columns');

    echo "PASS: SQL-backed Spam-X dispatcher preserves rules and version state\n";
} catch (Exception $e) {
    fwrite(STDERR,"FAIL: ".$e->getMessage()."\n");
    exit(1);
} finally {
    DB_query('DROP TABLE IF EXISTS gl_spamx_ci');
    DB_query('DROP TABLE IF EXISTS gl_plugins_ci');
}
