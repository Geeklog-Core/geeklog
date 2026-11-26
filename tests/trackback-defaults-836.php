<?php

error_reporting(E_ALL);

date_default_timezone_set('UTC');

// Simulate the installer group lookup.
$_TABLES = array('groups' => 'groups');

function DB_getItem($table, $field, $where = '')
{
    if ($table === 'groups' && $field === 'grp_id') {
        return 1;
    }

    throw new RuntimeException('Unexpected database lookup');
}

require_once dirname(__DIR__)
    . '/system/classes/IP.php';

require_once dirname(__DIR__)
    . '/system/classes/ConfigInterface.php';

class ConfigRecorder implements \Geeklog\ConfigInterface
{
    public $values = array();

    public static function get_instance()
    {
        return new self();
    }

    public function add(
        $param_name,
        $default_value,
        $type,
        $subgroup,
        $fieldset = null,
        $selection_array = null,
        $sort = 0,
        $set = true,
        $group = 'Core',
        $tab = null
    ) {
        $this->values[$param_name] = $default_value;
    }
}

require_once dirname(__DIR__)
    . '/public_html/admin/install/config-install.php';

$config = ConfigRecorder::get_instance();

install_config($config);

$passed = 0;

foreach (array(
    'trackback_enabled',
    'pingback_enabled',
    'ping_enabled'
) as $name) {
    if (!array_key_exists($name, $config->values) ||
        $config->values[$name] !== false) {
        throw new RuntimeException('FAIL: ' . $name);
    }

    echo 'OK: ' . $name . " = FALSE\n";
    ++$passed;
}

echo "\nTOTAL: $passed/3 checks passed\n";
