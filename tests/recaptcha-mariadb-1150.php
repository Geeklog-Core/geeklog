<?php
/**
 * MariaDB-backed reCAPTCHA migration regression (#1150).
 * Requires a disposable recaptcha_ci database and restricted test account.
 * Uses the actual Geeklog config class with a minimal mysqli adapter.
 */
error_reporting(E_ALL);
set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});
$_SERVER['PHP_SELF'] = 'migration-test.php';
define('GL_INSTALL_ACTIVE', true);
define('RECAPTCHA_SUPPORT_V3', 4);
define('RECAPTCHA_DEFAULT_SCORE_THRESHOLD', 0.5);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if (getenv('RECAPTCHA_DB_NAME') !== 'recaptcha_ci' ||
    getenv('RECAPTCHA_DB_USER') !== 'recaptcha_ci' ||
    !getenv('RECAPTCHA_DB_HOST') || !getenv('RECAPTCHA_DB_PASSWORD')) {
    fwrite(STDERR, "Use a dedicated recaptcha_ci database and account; set RECAPTCHA_DB_HOST, RECAPTCHA_DB_USER, RECAPTCHA_DB_PASSWORD and RECAPTCHA_DB_NAME.\n");
    exit(2);
}
$db = new mysqli(getenv('RECAPTCHA_DB_HOST'), getenv('RECAPTCHA_DB_USER'),
    getenv('RECAPTCHA_DB_PASSWORD'), getenv('RECAPTCHA_DB_NAME'));
$db->set_charset('utf8mb4');
$_TABLES = array('conf_values' => 'gl_conf_values_ci');
$_DB_dbms = 'mysql';
$_RECAPTCHA_CONF = array();
function DB_query($sql) {
    global $db;
    return $db->query($sql);
}
function DB_escapeString($value) {
    global $db;
    return $db->real_escape_string((string) $value);
}
function DB_fetchArray($result) {
    return $result->fetch_array(MYSQLI_BOTH);
}
function verify($condition, $message) {
    if (!$condition) {
        throw new Exception('FAIL: ' . $message);
    }
    echo 'PASS: ' . $message . PHP_EOL;
}
require __DIR__ . '/../system/classes/config.class.php';
require __DIR__ . '/../plugins/recaptcha/install_updates.php';
DB_query("CREATE TEMPORARY TABLE gl_conf_values_ci (
    name VARCHAR(50), value TEXT, type VARCHAR(50), group_name VARCHAR(50),
    default_value TEXT, subgroup INT, selectionArray INT, sort_order INT,
    tab INT, fieldset INT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
$c = config::get_instance();
$legacy = array(
    'public_key' => 'legacy-public-key',
    'secret_key' => 'legacy-secret-key',
    'logging' => 1,
    'anonymous_only' => 1,
    'remoteusers' => 0,
    'enable_comment' => 0,
    'enable_registration' => 1
);
foreach ($legacy as $key => $value) {
    $c->add($key, $value, is_string($value) ? 'text' : 'select',
        0, 0, null, 0, true, 'recaptcha', 0);
}
$c->add('test_marker', 'preserved', 'text', 0, 0, null, 0, true, 'Core', 0);
verify(recaptcha_update_ConfValues_1_1_6() === true, 'Migration completed');
$result = DB_query("SELECT name, value FROM gl_conf_values_ci WHERE group_name = 'recaptcha'");
$stored = array();
while ($row = DB_fetchArray($result)) {
    $stored[$row['name']] = unserialize($row['value']);
}
verify($stored['site_key'] === 'legacy-public-key', 'Public key preserved');
verify($stored['secret_key'] === 'legacy-secret-key', 'Secret key preserved');
verify($stored['logging'] === 1, 'Logging preference preserved');
verify($stored['anonymous_only'] === 1, 'Anonymous preference preserved');
verify($stored['remoteusers'] === 0, 'Remote users preference preserved');
verify($stored['enable_comment'] === 0, 'Disabled option preserved');
verify($stored['enable_registration'] === 1, 'Enabled option preserved');
verify(!array_key_exists('public_key', $stored), 'Legacy public_key removed');
verify($stored['enable_forum'] === 0, 'Missing optional setting initialized');
$result = DB_query("SELECT value FROM gl_conf_values_ci WHERE group_name = 'Core' AND name = 'test_marker'");
$row = DB_fetchArray($result);
verify($result->num_rows === 1 && unserialize($row['value']) === 'preserved',
    'Other configuration groups preserved');
echo "=== ALL RECAPTCHA TESTS PASSED ===\n";
