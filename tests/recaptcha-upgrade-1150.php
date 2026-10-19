<?php
/**
 * Standalone regression test for reCAPTCHA legacy configuration migration (#1150).
 * Run: php tests/recaptcha-upgrade-1150.php
 * No Geeklog installation or database required.
 */
error_reporting(E_ALL);
$_SERVER['PHP_SELF'] = 'recaptcha-upgrade-1150.php';
define('RECAPTCHA_SUPPORT_V3', 4);
define('RECAPTCHA_DEFAULT_SCORE_THRESHOLD', 0.5);

class config
{
    public static $instance;
    public $stored = [];
    public $added = [];
    public static function get_instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function get_config($group)
    {
        return $this->stored;
    }
    public function add($key, $value)
    {
        $this->added[$key] = $value;
    }
}
function DB_query($sql)
{
    return true;
}
$_TABLES = ['conf_values' => 'gl_conf_values'];
$_RECAPTCHA_CONF = ['public_key' => 'file-site-key', 'secret_key' => 'file-secret-key'];
require_once __DIR__ . '/../plugins/recaptcha/install_updates.php';

$c = config::get_instance();
$c->stored = [
    'public_key' => 'stored-site-key',
    'secret_key' => 'stored-secret-key',
    'enable_comment' => 0,
    'logging' => 1
];
recaptcha_update_ConfValues_1_1_6();
$expected = [
    'site_key' => 'stored-site-key',
    'secret_key' => 'stored-secret-key',
    'enable_comment' => 0,
    'logging' => 1,
    'enable_forum' => 0
];
foreach ($expected as $key => $value) {
    if (!array_key_exists($key, $c->added) || $c->added[$key] !== $value) {
        fwrite(STDERR, "Failed: {$key}\n");
        exit(1);
    }
}
echo "PASS: legacy settings preserved in configuration rebuild\n";
