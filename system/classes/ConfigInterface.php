<?php

namespace Geeklog;

/**
 * Interface ConfigInterface
 * @package Geeklog
 */
interface ConfigInterface
{
    public static function get_instance();
    public function add($param_name, $default_value, $type, $subgroup, $fieldset = null,
                 $selection_array = null, $sort = 0, $set = true, $group = 'Core', $tab = null);
}
