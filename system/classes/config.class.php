<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | config.class.php                                                          |
// |                                                                           |
// | Controls the UI and database for configuration settings                   |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2011 by the following authors:                         |
// |                                                                           |
// | Authors: Aaron Blankstein  - kantai AT gmail DOT com                      |
// |          Akeda Bagus       - admin AT gedex DOT web DOT id                |
// |          Tom Homer         - tomhomer AT gmail DOT com                    |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

use Geeklog\ConfigInterface;

class config implements ConfigInterface
{
    /**
     * Path to db-config.php file
     *
     * @var string
     */
    private $dbconfig_file;

    /**
     * Array of configurations
     *
     * @var array
     */
    private $config_array = array();

    /**
     * Array of configuration tabs, used by autocomplete
     *
     * @var array
     */
    private $conf_tab_arr;

    /**
     * Array of configuration features (security rights)
     *
     * @var array
     */
    private $conf_ft_arr = array();

    /**
     * Array of configuration types
     *
     * @var array
     */
    private $conf_type = array();

    /**
     * Whether support new theme format for the later Geeklog 2.0 or not
     *
     * @var boolean
     */
    private $flag_version_2;

    /**
     * List of validation rules. Append entries for validation as
     * ('field_name' => '/^perl_compat_regexp$/') that have to match
     * with preg_match(). Use these rules with config::_validates()
     *
     * @var array
     */
    public $validate = array();

    /**
     * List of validation errors.
     *
     * @var array
     */
    public $validationErrors = array();

    /**
     * Values that failed validation
     *
     * @var array
     */
    public $validationErrorValues = array();

    /**
     * Changed values that pass the validation.
     * If validationErrors is not empty, changed values should be saved
     * for later submission
     *
     * @var array
     */
    public $tmpValues = array();

    /**
     * Changed configuration array (such as mail settings) that pass the validation.
     * If validationErrors is not empty, changed values should be saved
     * for later submission
     *
     * @var array
     */
    public $changedArray = array();

    /**
     * Constructor
     */
    private function __construct()
    {
        $this->config_array = array();
        $this->conf_tab_arr = null;
        $this->conf_ft_arr = null;
        $this->conf_type = array();
    }

    /**
     * This method will return an instance of the config class. If an
     * instance with the given group/reference name does not exist, then it
     * will create a new one. This function insures    that there is only one
     * instance for a given group name.
     *
     * @return config The newly created or referenced config object
     */
    public static function get_instance()
    {
        static $instance;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * This method sets the secure configuration file (database related
     * settings) for the configuration class to read. This should only need to
     * be called for the 'Core' group. It also must be called before
     * load_baseconfig()
     *
     * @param string $sf The filename and path of the secure db settings
     */
    public function set_configfile($sf)
    {
        $this->dbconfig_file = $sf;
    }

    /**
     * This method reads the secure configuration file and loads
     * lib-database.php. This needs to be called in the 'Core' group before
     * &init_config() can be used. It only needs to be called once
     */
    public function load_baseconfig()
    {
        global $_DB, $_TABLES, $_CONF;

        include $this->dbconfig_file;
        $this->config_array['Core'] =& $_CONF;

        include_once $_CONF['path_system'] . 'lib-database.php';

        // for backward compatibility
        $_CONF['ostype'] = PHP_OS;
    }

    /**
     * This method initializes the configuration array (i.e. $_CONF) and
     * will return a reference to the newly created array. The class keeps
     * track of this reference, and the set function will mutate it.
     *
     * @return array(string => mixed)      This is a reference to the config array
     */
    public function &initConfig()
    {
        global $_TABLES;

        // Figure out tabs first
        $sql = "SELECT name, value, group_name, type, subgroup, tab FROM {$_TABLES['conf_values']} WHERE 1=1";
        $result = DB_query($sql);
        $tabs = array();
        $curr_group_name = '';
        $curr_subgroup = '';
        while ($row = DB_fetchArray($result)) {
            // For backwards compatibility, add in a tab for plugins that support the old config
            if (($row['type'] !== 'tab') && ($row['tab'] == '') && ($row['group_name'] != $curr_group_name || $row['subgroup'] != $curr_subgroup)) {
                $curr_group_name = $row['group_name'];
                $curr_subgroup = $row['subgroup'];
                $tab_name = 'tab_default_' . $curr_subgroup;
                $tab_id = 0;
                $this->conf_type['tab'][$row[2]][$tab_name] = "config.{$row[2]}.{$tab_name}";
                $this->conf_type['tree'][$row[2]][$row[4]][$tab_name] = "config.{$row[2]}.{$tab_name}";

                if (!isset($this->conf_tab_arr[$tab_name])) {
                    $this->conf_tab_arr[$row[2]][$row[4]][$tab_name] = array();
                    $tabs[$row[2]][$row[4]][$tab_id] = $tab_name;
                }
                continue;
            }

            // group the tab type
            if ($row[3] === 'tab') {
                $this->conf_type['tab'][$row[2]][$row[0]] = "config.{$row[2]}.{$row[0]}";
                $this->conf_type['tree'][$row[2]][$row[4]][$row[0]] = "config.{$row[2]}.{$row[0]}";

                if (!isset($this->conf_tab_arr[$row[0]])) {
                    $this->conf_tab_arr[$row[2]][$row[4]][$row[0]] = array();
                    $tabs[$row[2]][$row[4]][$row[5]] = $row[0];
                }
                continue;
            }

        }

        // Now figure out other info since tabs are now specified
        $sql = "SELECT name, value, group_name, type, subgroup, tab FROM {$_TABLES['conf_values']} WHERE type <> 'tab'";
        $result = DB_query($sql);
        $false_str = serialize(false);
        while ($row = DB_fetchArray($result)) {
            // Set any null tab to 0 since they now have been defaulted above
            if ($row[5] == '') {
                $row[5] = 0;
            }

            // group the subgroup type
            if ($row[3] === 'subgroup') {
                $this->conf_type['subgroup'][$row[2]][$row[0]] = $row[0];
                continue;
            }

            // group the fieldset type
            if ($row[3] === 'fieldset') {
                $this->conf_type['fieldset'][$row[2]][$row[0]] = $row[0];
                //    continue;
            }

            $autoCompleteData = $row[0];

            if ($row[1] !== 'unset') {
                if (!array_key_exists($row[2], $this->config_array) ||
                    !array_key_exists($row[0], $this->config_array[$row[2]])
                ) {
                    $value = @unserialize($row[1]);
                    if (($value === false) && ($row[1] !== $false_str)) {
                        if (function_exists('COM_errorLog')) {
                            COM_errorLog("Unable to unserialize {$row[1]} for {$row[2]}:{$row[0]}");
                        }
                    } else {
                        $this->config_array[$row[2]][$row[0]] = $value;

                        if (strpos($row[3], '@') === 0) { // if @
                            if (is_array($value) && !empty($value)) {
                                $autoCompleteData = array_keys($value);
                            }
                        }
                    }
                }
            }

            // set to auto complete
            $this->conf_tab_arr[$row[2]][$row[4]][$tabs[$row[2]][$row[4]][$row[5]]][$row[5]][$row[0]] = $autoCompleteData;
        }

        $this->_post_initconfig();
        $this->_post_configuration();

        return $this->config_array;
    }

    /**
     * Get configurations for particular group.
     *
     * @param string $group         Group name
     * @return bool|array           Array of configurations for specified group
     *                              or returns false if group doesn't exist
     */
    public function &get_config($group)
    {
        $retval = false;

        if (array_key_exists($group, $this->config_array)) {
            return $this->config_array[$group];
        }

        return $retval;
    }

    /**
     * Check if group exists or not
     *
     * @param   string $group Group name
     * @return  bool          True if group exists
     */
    public function group_exists($group)
    {
        return array_key_exists($group, $this->config_array);
    }

    /**
     * Check if tab exists or not
     *
     * @param   string $group Group name
     * @param   string $tab   Tab name
     * @return  bool          True if group exists
     */
    public function tab_exists($group, $tab)
    {
        $tab = strtolower($tab);
        if (strpos($tab, 'tab_') !== 0) {
            $tab = 'tab_' . $tab;
        }

        if (isset($this->conf_tab_arr[$group])) {
            foreach ($this->conf_tab_arr[$group] as $itemGroups) {
                foreach ($itemGroups as $tabName => $values) {
                    if ($tab === $tabName) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Return all group names
     *
     * @return  array of group names
     */
    public function getAllGroups()
    {
        return array_keys($this->config_array);
    }

    /**
     * Return all tab names of a given group
     *
     * @param   string $group Group name
     * @return  array of tab names
     */
    public function getAllTabs($group)
    {
        $retval = array();

        if (isset($this->conf_tab_arr[$group])) {
            foreach ($this->conf_tab_arr[$group] as $itemGroups) {
                foreach ($itemGroups as $tabName => $values) {
                    $retval[] = str_replace('tab_', '', $tabName);
                }
            }
        }

        return $retval;
    }

    /**
     * This method sets a configuration variable to a value in the database
     * and in the current array. If the variable does not already exist,
     * nothing will happen.
     *
     * @param   string $name  Name of the config parameter to set
     * @param   mixed  $value The value to set the config parameter to
     * @param   string $group
     * @return  void
     */
    public function set($name, $value, $group = 'Core')
    {
        global $_TABLES;

        $escaped_val = DB_escapeString(serialize($value));
        $escaped_name = DB_escapeString($name);
        $escaped_grp = DB_escapeString($group);
        $sql = "UPDATE {$_TABLES['conf_values']} SET value = '{$escaped_val}' "
            . "WHERE name = '{$escaped_name}' AND group_name = '{$escaped_grp}'";
        $this->_DB_escapedQuery($sql);
        $this->config_array[$group][$name] = $value;
    }

    /**
     * This method sets the default of a configuration variable to a value in
     * the database but not in the current array.
     * If the variable does not already exist, nothing will happen.
     *
     * @param   string $name  Name of the config parameter to set
     * @param   mixed  $value The value to set the config parameter to
     * @param   string $group Config group name ('Core' or plugin name)
     * @return  void
     */
    public function set_default($name, $value, $group = 'Core')
    {
        global $_TABLES;

        $escaped_val = DB_escapeString(serialize($value));
        $escaped_name = DB_escapeString($name);
        $escaped_grp = DB_escapeString($group);
        $sql = "UPDATE {$_TABLES['conf_values']} SET default_value = '{$escaped_val}' "
            . "WHERE name = '{$escaped_name}' AND group_name = '{$escaped_grp}'";
        $this->_DB_escapedQuery($sql);
    }

    /**
     * This method restores the default value (specified in the default_value field)
     * of a configuration variable.
     *
     * @param   string $name   Configuration variable's name
     * @param   string $group  Group name of configuration variable
     * @param   int    $sg     Subgroup of configuration variable
     * @param   string $tab_id Tab id
     * @return  bool           True on succeed
     */
    public function restore_param($name, $group, $sg = null, $tab_id = null)
    {
        global $_TABLES;

        $escaped_name = DB_escapeString($name);
        $escaped_grp = DB_escapeString($group);

        if (empty($tab_id) && ($tab_id !== '0')) {
            $tab_id = DB_getItem($_TABLES['conf_values'], 'tab',
                "name = '{$escaped_name}' AND group_name = '{$escaped_grp}'");
            if (empty($tab_id) && ($tab_id !== '0')) {
                return false;
            }
        }

        // check if current user other than Root has access to
        $tab_name = $this->_get_tab_name($group, $tab_id);
        $ft = $this->conf_type['tab'][$group][$tab_name];
        if (!SEC_inGroup('Root') && !SEC_hasRights($ft)) {
            return false;
        }

        $result = DB_query("SELECT value, default_value FROM {$_TABLES['conf_values']} WHERE name = '{$escaped_name}' AND group_name = '{$escaped_grp}'");
        list($value, $default_value) = DB_fetchArray($result);

        $sql = "UPDATE {$_TABLES['conf_values']} ";
        if ($value === 'unset') {
            $default_value = DB_escapeString($default_value);
            $sql .= "SET value = '{$default_value}', default_value = 'unset:{$default_value}'";
        } else {
            $sql .= "SET value = default_value";
        }
        $sql .= " WHERE name = '{$escaped_name}' AND group_name = '{$escaped_grp}'";
        $this->_DB_escapedQuery($sql);

        return true;
    }

    /**
     * This method sets a configuration variable's value to 'unset'.
     *
     * @param   string $name   Configuration variable's name
     * @param   string $group  Group name of configuration variable
     * @param   int    $sg     Subgroup of configuration variable
     * @param   string $tab_id Tab id
     * @return  bool           True on succeed
     */
    public function unset_param($name, $group, $sg = null, $tab_id = '')
    {
        global $_TABLES;

        $escaped_name = DB_escapeString($name);
        $escaped_grp = DB_escapeString($group);

        if (empty($tab_id) && ($tab_id !== '0')) {
            $tab_id = DB_getItem($_TABLES['conf_values'], 'tab',
                "name = '{$escaped_name}' AND group_name = '{$escaped_grp}'");
            if (empty($tab_id) && ($tab_id !== '0')) {
                return false;
            }
        }

        // check if current user other than Root has access to
        $tab_name = $this->_get_tab_name($group, $tab_id);
        $ft = $this->conf_type['tab'][$group][$tab_name];
        if (!SEC_inGroup('Root') && !SEC_hasRights($ft)) {
            return false;
        }

        $default_value = DB_getItem($_TABLES['conf_values'], 'default_value',
            "name = '{$escaped_name}' AND group_name = '{$escaped_grp}'");
        $sql = "UPDATE {$_TABLES['conf_values']} SET value = 'unset'";
        if (substr($default_value, 0, 6) === 'unset:') {
            $default_value = DB_escapeString(substr($default_value, 6));
            $sql .= ", default_value = '{$default_value}'";
        }
        $sql .= " WHERE name = '{$escaped_name}' AND group_name = '{$escaped_grp}'";
        $this->_DB_escapedQuery($sql);

        return true;
    }

    /**
     * Adds a configuration variable to the config object
     *
     * @param string  $param_name        name of the parameter to add
     * @param mixed   $default_value     the default value of the parameter
     *                                   (also will be the initial value)
     * @param string  $type              the type of the configuration variable
     *                                   If the configuration variable is an array, prefix this string with
     *                                   '@' if the administrator should NOT be able to add or remove keys
     *                                   '*' if the administrator should be able to add named keys
     *                                   '%' if the administrator should be able to add numbered keys
     *                                   These symbols can be repeated like such: @@text if the configuration
     *                                   variable is an array of arrays of text.
     *                                   The base variable types are:
     *                                   'text'    textbox displayed     string  value stored
     *                                   'select'  selectbox displayed   string  value stored
     *                                   'hidden'  no display            string  value stored
     * @param string  $subgroup          subgroup of the variable
     *                                   (the second row of tabs on the user interface)
     * @param string  $fieldset          the fieldset to display the variable under
     * @param array   $selection_array   possible selections for the 'select' type
     *                                   this MUST be passed if you use the 'select'
     *                                   type
     * @param int     $sort              sort rank on the user interface (ascending)
     * @param boolean $set               whether or not this parameter is set to config_array property
     * @param string  $group             group of the variable
     * @param string  $tab               the tab to display the variable under
     */
    public function add($param_name, $default_value, $type, $subgroup, $fieldset = null,
                        $selection_array = null, $sort = 0, $set = true, $group = 'Core', $tab = null)
    {
        global $_TABLES;

        $Qargs = array($param_name,
            $set ? serialize($default_value) : 'unset',
            $type,
            $subgroup,
            $group,
            ($selection_array === null ?
                -1 : $selection_array),
            $sort,
            ($fieldset === null ?
                0 : $fieldset),
            serialize($default_value),
        );

        $columns = 'name, value, type, subgroup, group_name, selectionArray, sort_order, fieldset, default_value';

        // special handling of $tab for backward compatibility
        if ($tab !== null) {
            $columns .= ', tab';
            $Qargs[9] = $tab;
        }
        $Qargs = array_map('DB_escapeString', $Qargs);

        // Delete old config value if exists (incase re-adding it for developer db update script)
        $sql = "DELETE FROM {$_TABLES['conf_values']} WHERE name = '{$Qargs[0]}' AND group_name = '{$Qargs[4]}' AND subgroup={$Qargs[3]}";
        $this->_DB_escapedQuery($sql);

        // Now add in config item
        $sql = "INSERT INTO {$_TABLES['conf_values']} ($columns) VALUES ("
            . "'{$Qargs[0]}',"
            . "'{$Qargs[1]}',"
            . "'{$Qargs[2]}',"
            . "{$Qargs[3]},"
            . "'{$Qargs[4]}',"
            . "{$Qargs[5]},"
            . "{$Qargs[6]},"
            . "'{$Qargs[7]}',"
            . "'{$Qargs[8]}'";
        if ($tab !== null) {
            $sql .= ",{$Qargs[9]}";
        }
        $sql .= ')';

        $this->_DB_escapedQuery($sql);

        if ($set) {
            $this->config_array[$group][$param_name] = $default_value;
        }
    }

    /**
     * Updates a configuration variable in the db and array
     *
     * @param string  $param_name        name of the parameter to add
     * @param mixed   $default_value     the default value of the parameter
     *                                   (also will be the initial value)
     * @param string  $type              the type of the configuration variable
     *                                   If the configuration variable is an array, prefix this string with
     *                                   '@' if the administrator should NOT be able to add or remove keys
     *                                   '*' if the administrator should be able to add named keys
     *                                   '%' if the administrator should be able to add numbered keys
     *                                   These symbols can be repeated like such: @@text if the configuration
     *                                   variable is an array of arrays of text.
     *                                   The base variable types are:
     *                                   'text'    textbox displayed     string  value stored
     *                                   'select'  selectbox displayed   string  value stored
     *                                   'hidden'  no display            string  value stored
     * @param string  $subgroup          subgroup of the variable
     *                                   (the second row of tabs on the user interface)
     * @param string  $fieldset          the fieldset to display the variable under
     * @param array   $selection_array   possible selections for the 'select' type
     *                                   this MUST be passed if you use the 'select'
     *                                   type
     * @param int     $sort              sort rank on the user interface (ascending)
     * @param boolean $set               whether or not this parameter is set to config_array property
     * @param string  $group             group of the variable
     * @param string  $tab               the tab to display the variable under
     */
    function update($param_name, $default_value, $type, $subgroup, $fieldset,
                    $selection_array = null, $sort = 0, $set = true, $group = 'Core', $tab = null)
    {
        global $_TABLES;

        $columns = '';
        $Qargs = array(
            $param_name,
            ($set ? serialize($default_value) : 'unset'),
            $type,
            $subgroup,
            $group,
            ($selection_array === null ? -1 : $selection_array),
            $sort,
            $fieldset,
            serialize($default_value),
        );

        // special handling of $tab for backward compatibility
        if ($tab !== null) {
            $columns .= ', tab';
            $Qargs[9] = $tab;
        }

        $Qargs = array_map('DB_escapeString', $Qargs);

        $sql = "UPDATE {$_TABLES['conf_values']} SET sort_order={$Qargs[6]},fieldset={$Qargs[7]}" .
            " WHERE group_name='{$Qargs[4]}' AND name='{$Qargs[0]}'";

        $this->_DB_escapedQuery($sql, 1);
    }

    /**
     * Permanently deletes a parameter
     *
     * @param string $param_name This is the name of the parameter to delete
     * @param string $group      Configuration group name
     */
    public function del($param_name, $group)
    {
        DB_delete($GLOBALS['_TABLES']['conf_values'],
            array('name', 'group_name'),
            array(DB_escapeString($param_name), DB_escapeString($group))
        );
        unset($this->config_array[$group][$param_name]);
    }

    /**
     * Gets extended (GUI related) information from the database
     *
     * @param  string $subgroup filters by subgroup
     * @param  string $group
     * @return array(string => string => array(string => mixed))
     *                          Array keys are fieldset => parameter named => information array
     */
    function _get_extended($subgroup, $group)
    {
        global $_TABLES, $LANG_confignames, $LANG_configselects;

        $q_string = "SELECT name, type, selectionArray, tab, value, default_value, fieldset FROM {$_TABLES['conf_values']}"
            . " WHERE group_name='" . DB_escapeString($group) . "' AND subgroup='" . DB_escapeString($subgroup) . "' "
            . " AND (type <> 'tab' AND type <> 'subgroup') "
            . " ORDER BY tab, fieldset, sort_order ASC";
        $Qresult = DB_query($q_string);
        $res = array();
        if (!array_key_exists($group, $LANG_configselects)) {
            $LANG_configselects[$group] = array();
        }
        if (!array_key_exists($group, $LANG_confignames)) {
            $LANG_confignames[$group] = array();
        }

        while ($row = DB_fetchArray($Qresult)) {
            $cur = $row;

            if ($cur[3] == '') {
                $cur[3] = 0;
            }  // If tab is null then old plugin so set default tab

            $cur[5] = (substr($cur[5], 0, 6) === 'unset:');
            $res[$cur[3]][$cur[0]] = array(
                'display_name'   => (array_key_exists($cur[0], $LANG_confignames[$group]) ? $LANG_confignames[$group][$cur[0]] : $cur[0]),
                'type'           => (($cur[4] === 'unset') ? 'unset' : $cur[1]),
                'selectionArray' => (($cur[2] != -1) ? $LANG_configselects[$group][$cur[2]] : null),
                'value'          => (($cur[4] === 'unset') ? 'unset' : unserialize($cur[4])),
                'fieldset'       => $cur[6],
                'reset'          => $cur[5],
            );
        }

        return $res;
    }

    /**
     * Changes any config settings that depend on other configuration settings.
     * Called by config::initConfig
     *
     * @return void
     */
    private function _post_initconfig()
    {
        global $_USER;

        $theme = $this->config_array['Core']['theme'];
        if ($this->config_array['Core']['allow_user_themes'] == 1 && !empty($_USER['theme'])) {
            $theme = $_USER['theme'];
        }
        $this->config_array['Core']['path_themes'] = $this->config_array['Core']['path_html'] . 'layout/'; // Cannot be set by admin anymore
        $this->config_array['Core']['path_layout'] = $this->config_array['Core']['path_themes'] . $theme . '/';
        $this->config_array['Core']['layout_url'] = $this->config_array['Core']['site_url'] . '/layout/' . $theme;
    }

    /**
     * Changes any config settings that depend on other configuration settings.
     * Called by config::initConfig and config::updateConfig
     *
     * @return void
     */
    private function _post_configuration()
    {
        $methods = array('standard', 'openid', '3rdparty', 'oauth');
        $methods_disabled = 0;
        foreach ($methods as $m) {
            if (isset($this->config_array['Core']['user_login_method'][$m]) &&
                !$this->config_array['Core']['user_login_method'][$m]
            ) {
                $methods_disabled++;
            }
        }
        if ($methods_disabled == count($methods)) {
            // just to make sure people don't lock themselves out of their site
            $this->config_array['Core']['user_login_method']['standard'] = true;

            // TBD: ensure that we have a Root user able to log in with the
            //      enabled login method(s)
        }
    }

    /**
     * Get configuration groups for current logged user.
     * Plugins being disabled are ignored. Configurations
     * that user doesn't access to are ignored.
     *
     * @return array Array of configuration groups.
     */
    public function _get_groups()
    {
        global $_TABLES;

        $groups = array_keys($this->config_array);
        $num_groups = count($groups);
        for ($i = 0; $i < $num_groups; $i++) {
            $g = $groups[$i];
            // Only collect plugins that are enabled
            if ($g !== 'Core') {
                $enabled = DB_getItem($_TABLES['plugins'], 'pi_enabled', "pi_name = '{$g}'");
                if (isset($enabled) && ($enabled == 0)) {
                    unset($groups[$i]);
                    continue;
                }
            }

            // check if current user other than Root has access to
            $tabs = array_values($this->conf_type['tab'][$g]);
            if (!SEC_inGroup('Root') && !SEC_hasRights($tabs, 'OR')) {
                unset($groups[$i]);
            }
        }

        return $groups;
    }

    /**
     * Get configuration subgroups for particular configuration group.
     *
     * @param   string $group Configuration group name
     * @return  array         Array of subgroups that belong to configuration $group
     */
    private function _get_sgroups($group)
    {
        global $_TABLES;

        $group = DB_escapeString($group);
        $q_string = "SELECT name,subgroup FROM {$_TABLES['conf_values']} "
            . "WHERE type = 'subgroup' AND group_name = '{$group}' "
            . "ORDER BY subgroup";
        $retval = array();
        $res = DB_query($q_string);

        while ($row = DB_fetchArray($res)) {
            // check if current user has access to current subgroup
            $tabs = array_values($this->conf_type['tree'][$group][$row['subgroup']]);
            if (!SEC_inGroup('Root') && !SEC_hasRights($tabs, 'OR')) {
                continue;
            }
            $retval[$row['name']] = $row['subgroup'];
        }

        return $retval;
    }

    /**
     * Get tab name based on sepecified group name and tab id.
     *
     * @param  string $group  Group name
     * @param  int    $tab_id tab id
     * @return string
     */
    private function _get_tab_name($group, $tab_id)
    {
        global $_TABLES;

        $group = DB_escapeString($group);

        return DB_getItem($_TABLES['conf_values'], 'name',
            "type = 'tab' AND tab = {$tab_id} AND group_name = '{$group}'");
    }

    /**
     * Get fieldset name based on specified tab id.
     *
     * @param  string $tab_id tab id
     * @param  int    $fs_id  fieldset id
     * @return string
     */
    function _get_fs_name($tab_id, $fs_id)
    {
        global $_TABLES;

        return DB_getItem($_TABLES['conf_values'], 'name',
            "type = 'fieldset' AND fieldset = {$fs_id} AND tab = '{$tab_id}'");

    }

    /**
     * This function is responsible for creating the configuration GUI
     *
     * @param string $grp           This is the group name to load the gui for.
     * @param string $sg            This is the subgroup name to load the gui for.
     *                              If nothing is passed, it will display the first
     *                              (alpha) subgroup.
     * @param mixed  $change_result This is an array of what changes were made to the
     *                              configuration - if it is passed, it will display
     *                              the "Changes" message box.
     * @return string
     */
    public function get_ui($grp, $sg = '0', $change_result = null)
    {
        global $_CONF, $LANG_CONFIG, $LANG_configsubgroups, $LANG_fs, $_SCRIPTS, $_USER, $LANG01;

        if (!array_key_exists($grp, $LANG_configsubgroups)) {
            $LANG_configsubgroups[$grp] = array();
        }

        // denied users that don't have access to configuration
        $groups = $this->_get_groups();
        if (empty($groups)) {
            return self::UI_perm_denied();
        }

        if (!isset($sg) || empty($sg)) {
            $sg = '0';

            // get default subgroup for non Root user
            if (!SEC_inGroup('Root')) {
                $default_sg = $this->_get_sgroups($grp);
                if (!empty($default_sg)) {
                    $default_sg = array_values($default_sg);
                    $sg = $default_sg[0];
                } else {
                    return self::UI_perm_denied();
                }
            }
        }

        $t = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'admin/config'));
        $t->set_file(array(
            'main'      => 'configuration.thtml',
            'menugroup' => 'menu_element.thtml',
        ));

        $link_message = $LANG01[139];
        $t->set_var('noscript', COM_getNoScript(false, '', $link_message));
        // Hide the Configuration as Javascript is currently required. If JS is enabled then the JS below will un-hide it
        $js = 'document.getElementById("geeklog_config_editor").style.display="";';
        $_SCRIPTS->setJavaScript($js, true);

        $t->set_var('gltoken_name', CSRF_TOKEN);
        $t->set_var('gltoken', SEC_createToken());

        // set javascript variable for autocomplete
        $js = $this->_UI_autocomplete_data();
        // set javascript variable for image spinner
        $js .= $this->_UI_js_image_spinner();
        $js .= "var frmGroupAction = '" . $_CONF['site_admin_url'] . "/configuration.php';";
        $_SCRIPTS->setJavaScript($js, true);

        $this->flag_version_2 = version_compare($_CONF['supported_version_theme'], '2.0.0', '>=');

        if ($this->flag_version_2 == true) {
            $_SCRIPTS->setJavaScriptFile('admin.configuration', '/javascript/admin.configuration.js');
        } else {
            $_SCRIPTS->setJavaScriptFile('admin.configuration', '/javascript/ver.1.8/admin.configuration.js');
        }


        $t->set_var('search_configuration_label', $LANG_CONFIG['search_configuration_label']);
        if (isset($_POST['search-configuration-cached'])) {
            $t->set_var('search_configuration_value', Geeklog\Input::post('search-configuration-cached'));
        } else {
            $t->set_var('search_configuration_value', '');
        }
        if (isset($_POST['tab-id-cached'])) {
            $t->set_var('tab_id_value', Geeklog\Input::post('tab-id-cached'));
        } else {
            $t->set_var('tab_id_value', '');
        }

        $t->set_var('lang_save_changes', $LANG_CONFIG['save_changes']);
        $t->set_var('lang_reset_form', $LANG_CONFIG['reset_form']);

        $t->set_var('open_group', $grp);

        $outerLoopCounter = 1;
        if (count($groups) > 0) {
            $t->set_block('menugroup', 'subgroup-selector', 'subgroups');
            foreach ($groups as $group) {
                $t->set_var("select_id", ($group === $grp ? 'id="current"' : ''));
                $t->set_var("group_select_value", $group);
                $t->set_var("group_display", ucwords($group));
                $subgroups = $this->_get_sgroups($group);

                $innerLoopCounter = 1;
                foreach ($subgroups as $sgname => $sgroup) {
                    if ($grp == $group && $sg == $sgroup) {
                        $t->set_var('group_active_name', ucwords($group));
                        if (isset($LANG_configsubgroups[$group][$sgname])) {
                            $t->set_var('subgroup_active_name', $LANG_configsubgroups[$group][$sgname]);
                        } elseif (isset($LANG_configsubgroups[$group][$sgroup])) {
                            $t->set_var('subgroup_active_name', $LANG_configsubgroups[$group][$sgroup]);
                        } else {
                            $t->set_var('subgroup_active_name', $sgname);
                        }
                        $t->set_var('select_id', 'id="current"');
                    } else {
                        $t->set_var('select_id', '');
                    }
                    $t->set_var('subgroup_name', $sgroup);
                    if (isset($LANG_configsubgroups[$group][$sgname])) {
                        $t->set_var('subgroup_display_name',
                            $LANG_configsubgroups[$group][$sgname]);
                    } else {
                        $t->set_var('subgroup_display_name', $sgname);
                    }
                    if ($innerLoopCounter == 1) {
                        $t->parse('subgroups', "subgroup-selector");
                    } else {
                        $t->parse('subgroups', "subgroup-selector", true);
                    }
                    $innerLoopCounter++;
                }
                $t->set_var('cntr', $outerLoopCounter);
                $t->parse("menu_elements", "menugroup", true);
                $outerLoopCounter++;
            }
        } else {
            $t->set_var('hide_groupselection', 'none');
        }

        $t->set_var('open_sg', $sg);
        $t->set_block('main', 'tab', 'sg_contents');
        $t->set_block('tab', 'notes', 'tab_notes');

        $ext_info = $this->_get_extended($sg, $grp);
        $tab_li = '<ul>';
        foreach ($ext_info as $tab => $params) {
            $tab_contents = '';
            $current_fs = '';
            $fs_flag = false;
            $table_flag = false;
            //print_r($params);
            foreach ($params as $name => $e) {
                if (COM_isDemoMode()) {
                    if ( in_array($name,array(
                    'site_url','site_admin_url'
                    ,'url_routing'
                    
                    ,'path_html','path_log','path_language','backup_path','path_data','path_data','path_themes','path_images','path_editors','rdf_file'
                    
                    ,'path_to_mogrify', 'path_to_netpbm', 'image_lib'
                    
                    ,'custom_registration','user_login_method'
                    
                    ,'mail_cc_enabled','mail_cc_default'
                    
                    ,'facebook_login','facebook_consumer_key','facebook_consumer_secret'
                    ,'linkedin_login','linkedin_consumer_key','linkedin_consumer_secret'
                    ,'twitter_login','twitter_consumer_key','twitter_consumer_secret'
                    ,'google_login','google_consumer_key','google_consumer_secret'
                    ,'microsoft_login','microsoft_consumer_key','microsoft_consumer_secret'
                    ,'yahoo_login','yahoo_consumer_key','yahoo_consumer_secret'
                    ,'github_login','github_consumer_secret','github_consumer_key'
                    
                    ,'filemanager_upload_restrictions','filemanager_images_ext','filemanager_videos_ext','filemanager_audios_ext'
                    
                    // For reCaptcha Plugin
                    ,'public_key','private_key','enable_emailstory','enable_registration','enable_contact','remoteusers','anonymous_only'
                    ))) {
                        continue;
                    }
                }     

                if ($e['type'] === 'fieldset' && $e['fieldset'] != $current_fs) {
                    $fs_flag = true;
                    if ($current_fs != '') {

                        if ($this->flag_version_2 == true) {
                            $tab_contents .= '</div></fieldset><!-- END fieldset -->';
                        } else {
                            $tab_contents .= '</table></fieldset><!-- END fieldset -->';
                        }

                        $table_flag = false;
                    }
                    $tab_contents .= '<!-- BEGIN fieldset --><fieldset><legend>' . $LANG_fs[$grp][$e['display_name']] . '</legend>';
                    $current_fs = $e['fieldset'];
                }
                if (!$table_flag) {
                    if ($this->flag_version_2 == true) {
                        $tab_contents .= '<div class="inputTable">';
                    } else {
                        $tab_contents .= '<table class="inputTable">';
                    }

                    $table_flag = true;
                }

                if ($this->flag_version_2 == true) {
                    $tab_contents .=
                        $this->_UI_get_conf_element_2(
                            $grp, $name,
                            $e['display_name'],
                            $e['type'],
                            $e['value'],
                            $e['selectionArray'], false,
                            $e['reset']
                        );
                } else {
                    $tab_contents .=
                        $this->_UI_get_conf_element(
                            $grp, $name,
                            $e['display_name'],
                            $e['type'],
                            $e['value'],
                            $e['selectionArray'], false,
                            $e['reset']
                        );
                }
            }

            if ($table_flag) {
                if ($this->flag_version_2 == true) {
                    $tab_contents .= '</div>';
                } else {
                    $tab_contents .= '</table>';
                }
            }

            if ($fs_flag) {
                $tab_contents .= '</fieldset><!-- END fieldset -->';
            }

            // check if current user has access to current tab
            $tab_name = "config.{$grp}." . $this->_get_tab_name($grp, $tab);
            if (!SEC_inGroup('Root') && !SEC_hasRights($tab_name)) {
                continue;
            }
            // tab content
            $tab_display = $this->_UI_get_tab($grp, $tab_contents, $tab, $t);

            // tab list
            $tab_li .= '<li><a href="#tab-' . $tab . '">' . $tab_display . '</a></li>';
        }
        $tab_li .= '</ul>';
        $t->set_var('tab_li', $tab_li);

        $_SCRIPTS->setJavaScriptLibrary('jquery-ui'); // Require autocomplete, menu, and tabs

        $t->set_var('config_menu', $this->_UI_configmanager_menu($grp, $sg));

        // message box
        if ($change_result != null && $change_result !== array()) {
            $t->set_var('lang_changes_made', $LANG_CONFIG['changes_made'] . ':');
            $t->set_var('change_block', $this->_UI_get_change_block($change_result, $grp, $sg));
        } else {
            $t->set_var('show_changeblock', 'none');
        }
        if (!empty($this->validationErrors)) {
            $t->set_var('lang_changes_made', '');
            $t->set_var('show_changeblock', '');
            $t->set_var('change_block', $this->_UI_get_change_block(null, $grp, $sg));
            $t->set_var('lang_error_validation_occurs', $LANG_CONFIG['error_validation_occurs'] . ' :');
            $t->set_var('error_validation_class', ' error_validation');
        }

        $display = $t->finish($t->parse('OUTPUT', 'main'));
        $_CONF['theme'] = $_USER['theme'];
        $display = COM_createHTMLDocument(
            $display,
            array(
                'what'       => 'none',
                'pagetitle'  => $LANG_CONFIG['title'],
                'rightblock' => false,
            )
        );

        return $display;
    }

    /**
     * Get messages to display when changes were made to the configuration.
     *
     * @param  array  $changes Array of changes. Keys are configuration parameter name.
     * @param  string $group   Configuration group
     * @param  int    $sg      Configuration subgroup
     * @return string          string of HTML to be displayed on message box
     */
    private function _UI_get_change_block($changes, $group = null, $sg = null)
    {
        $display = '';
        $anchors = array();

        if (empty($this->validationErrors)) {
            if ($changes != null && $changes !== array()) {
                foreach ($changes as $param_name => $success) {
                    if (isset($this->changedArray[$group][$param_name])) {
                        foreach ($this->changedArray[$group][$param_name] as $_param_name => $_success) {
                            $anchors[] = ' <a href="#' . $param_name . '[' . $_param_name . ']' .
                                '" class="select_config"' .
                                (($group !== null) ? ' group="' . $group . '"' : '') .
                                (($sg !== null) ? ' subgroup="' . $sg . '"' : '') .
                                '>' . $param_name . '[' . $_param_name . ']' . '</a>';
                        }
                    } else {
                        $anchors[] = ' <a href="#' . $param_name . '" class="select_config"' .
                            (($group !== null) ? ' group="' . $group . '"' : '') .
                            (($sg !== null) ? ' subgroup="' . $sg . '"' : '') .
                            '>' . $param_name . '</a>';
                    }
                }
            }
        } else {
            foreach ($this->validationErrors as $grp => $errors) {
                foreach ($errors as $param_name => $error) {
                    $anchors[] = ' <a href="#' . $param_name . '" class="select_config"' .
                        (($group !== null) ? ' group="' . $group . '"' : '') .
                        (($sg !== null) ? ' subgroup="' . $sg . '"' : '') .
                        '>' . $param_name . '</a>';
                }
            }
        }

        if (!empty($anchors)) {
            $display = implode(',', $anchors);
        }

        return $display;
    }

    /**
     * Set tab from configuration where tab = $tab_id under the group $group
     * with content $contents to template $t
     *
     * @param  string $group    Configuration group
     * @param  string $contents Contents
     * @param  int    $tab_id   tab id
     * @param  object $t        Template object
     * @return string tab name to display based on current language
     */
    private function _UI_get_tab($group, $contents, $tab_id, &$t)
    {
        global $_TABLES, $LANG_tab, $LANG_CONFIG;

        if (!array_key_exists($group, $LANG_tab)) {
            $LANG_tab[$group] = array();
        }
        $t->set_var('tab_contents', $contents);
        $tab_index = DB_getItem($_TABLES['conf_values'], 'name',
            "type = 'tab' AND tab = $tab_id AND group_name = '$group'");

        if (empty($tab_index)) {
            if (empty($LANG_tab[$group][$tab_id])) {
                $tab_display = $LANG_CONFIG['default_tab_name'];
            } else {
                $tab_display = $LANG_tab[$group][$tab_id];
            }
        } elseif (isset($LANG_tab[$group][$tab_index])) {
            $tab_display = $LANG_tab[$group][$tab_index];
        } else {
            $tab_display = $tab_index;
        }
        $t->set_var('tab_id', "tab-{$tab_id}");
        $t->set_var('tab_display', $tab_display);
        $t->set_var('tab_notes', '');
        $t->parse('sg_contents', 'tab', true);

        // used by tab_li
        return $tab_display;
    }

    /**
     * Set fieldset from configuration where fieldset = $fs_id under the group $group
     * with content $contents to template $t
     *
     * @param  string   $group
     * @param  string   $contents Contents
     * @param  int      $fs_id
     * @param  Template $t        Template object
     * @return void
     */
    private function _UI_get_fs($group, $contents, $fs_id, $t)
    {
        global $_TABLES, $LANG_fs;

        if (!array_key_exists($group, $LANG_fs)) {
            $LANG_fs[$group] = array();
        }
        $t->set_var('fs_contents', $contents);
        $fs_index = DB_getItem($_TABLES['conf_values'], 'name',
            "type = 'fieldset' AND fieldset = $fs_id AND group_name = '$group'");
        if (empty($fs_index)) {
            $t->set_var('fs_display', $LANG_fs[$group][$fs_id]);
        } elseif (isset($LANG_fs[$group][$fs_index])) {
            $t->set_var('fs_display', $LANG_fs[$group][$fs_index]);
        } else {
            $t->set_var('fs_display', $fs_index);
        }
        $t->set_var('fs_notes', '');
        $t->parse('sg_contents', 'fieldset', true);
    }

    /**
     * Returns a page for permission denied
     *
     * @return  string HTML for permission denied page
     */
    public static function UI_perm_denied()
    {
        global $_USER, $MESSAGE;

        $display = COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
        $display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[30]));
        COM_accessLog("User {$_USER['username']} tried to illegally access the config administration screen.");

        return $display;
    }

    /**
     * Get a parsed config element based on group $group, name $name,
     * type $type, value to be shown $val and label $display_name to be shown
     * on the left based on language.
     *
     * @param  string $group          Configuration group.
     * @param  string $name           Configuration name on table.
     * @param  string $display_name   Configuration display name based on language.
     * @param  string $type           Configuration type such as select, text, textarea, @select, etc.
     * @param  string $val            Value of configuration
     * @param  mixed  $selectionArray Array of option of select element
     * @param  bool   $deletable      If configuration is deleteable
     * @param  bool   $allow_reset    Allow set and unset of configuration
     * @return string
     */
    private function _UI_get_conf_element($group, $name, $display_name, $type, $val,
                                          $selectionArray = null, $deletable = false,
                                          $allow_reset = false)
    {
        global $LANG_CONFIG;

        $t = COM_newTemplate(CTL_core_templatePath($GLOBALS['_CONF']['path_layout'] . 'admin/config'));
        $t->set_file('element', 'config_element.thtml');

        $blocks = array(
            'delete-button', 'text-element', 'placeholder-element',
            'select-element', 'list-element', 'unset-param',
            'keyed-add-button', 'unkeyed-add-button', 'text-area',
            'validation_error_block',
        );

        foreach ($blocks as $block) {
            $t->set_block('element', $block);
        }

        $t->set_var('lang_restore', $LANG_CONFIG['restore']);
        $t->set_var('lang_enable', $LANG_CONFIG['enable']);
        $t->set_var('lang_add_element', $LANG_CONFIG['add_element']);

        $t->set_var('name', $name);
        $t->set_var('id_name', str_replace(array('[', ']'), array('_', ''), $name));
        $t->set_var('display_name', $display_name);

        // check tmp values
        if (isset($this->tmpValues[$group][$name])) {
            $val = $this->tmpValues[$group][$name];
        }

        if (!is_array($val)) {
            if (is_float($val)) {
                /**
                 * @todo FIXME: for Locales where the comma is the decimal
                 *              separator, patch output to a decimal point
                 *              to prevent it being cut off by COM_applyFilter
                 */
                $t->set_var('value', str_replace(',', '.', $val));
            } else {
                $t->set_var('value', htmlspecialchars($val));
            }
        }

        // if there is a error message to shown
        if (isset($this->validationErrors[$group][$name])) {
            $t->set_var('validation_error_message', $this->validationErrors[$group][$name]);
            $t->set_var('error_block', $t->parse('output', 'validation_error_block'));
            $t->set_var('error_class', ' input_error');
            $t->set_var('value', $this->validationErrorValues[$group][$name]);
        } else {
            $t->set_var('error_class', '');
            $t->set_var('error_block', '');
        }

        if ($deletable) {
            $t->set_var('delete', $t->parse('output', 'delete-button'));
        } else {
            if ($allow_reset) {
                $t->set_var('unset_link',
                    "(<a href=\"#{$name}\" class=\"unset_param\" title='"
                    . $LANG_CONFIG['disable'] . "'>X</a>)");
            }
            if (($a = strrchr($name, '[')) !== false) {
                //$on = substr($a, 1, -1);
                $o = str_replace(array('[', ']'), array('_', ''), $name);
            } else {
                $o = $name;
                //$on = $name;
            }
            /*  As of v2.2.0 Removed numeric check for config help which indicates a config option variable is an array.
                The only thing that uses config variables which are an array at the moment is Security Default Permissions for items like Articles, Dynamic Blocks and Autotags usage permissions.
                It was determined tooltip was needed since users where wondering what they are needed for.
                This should not affect anything else.

            if (!is_numeric($on)) {
                $this->_set_ConfigHelp($t, $group, $o);
            }
            */ 
            $this->_set_ConfigHelp($t, $group, $o);
        }

        if ($type === 'unset') {
            return $t->finish($t->parse('output', 'unset-param'));
        } elseif ($type === 'text') {
            return $t->finish($t->parse('output', 'text-element'));
        } elseif ($type === 'textarea') {
            return $t->finish($t->parse('output', 'text-area'));
        } elseif ($type === 'placeholder') {
            return $t->finish($t->parse('output', 'placeholder-element'));
        } elseif ($type === 'select') {
            // if $name is like "blah[0]", separate name and index
            $n = explode('[', $name);
            $name = $n[0];
            $index = null;
            if (count($n) == 2) {
                $i = explode(']', $n[1]);
                $index = $i[0];
            }
            $type_name = $type . '_' . $name;
            if ($group === 'Core') {
                $fn = 'configmanager_' . $type_name . '_helper';
            } else {
                $fn = 'plugin_configmanager_' . $type_name . '_' . $group;
            }
            if (function_exists($fn)) {
                if ($index === null) {
                    $selectionArray = $fn();
                } else {
                    $selectionArray = $fn($index);
                }
            } elseif (is_array($selectionArray)) {
                // leave sorting to the function otherwise
                uksort($selectionArray, 'strcasecmp');
            }
            if (!is_array($selectionArray)) {
                return $t->finish($t->parse('output', 'text-element'));
            }

            $t->set_block('select-element', 'select-options', 'myoptions');
            foreach ($selectionArray as $sName => $sVal) {
                if (is_bool($sVal)) {
                    $t->set_var('opt_value', $sVal ? 'b:1' : 'b:0');
                } else {
                    $t->set_var('opt_value', $sVal);
                }
                $t->set_var('opt_name', $sName);
                $t->set_var('selected', ($val == $sVal ? 'selected="selected"' : ''));
                $t->parse('myoptions', 'select-options', true);
            }
            if ($index === 'placeholder') {
                $t->set_var('hide_row', ' style="display:none;"');
            }

            return $t->parse('output', 'select-element');
        } elseif (strpos($type, '@') === 0) {
            $result = '';
            foreach ($val as $valkey => $valval) {
                $result .= $this->_UI_get_conf_element($group,
                    $name . '[' . $valkey . ']',
                    $display_name . '[' . $valkey . ']',
                    substr($type, 1), $valval, $selectionArray,
                    false);
            }

            return $result;
        } elseif (strpos($type, '*') === 0 || strpos($type, '%') === 0) {
            $t->set_var('arr_name', $name);
            $t->set_var('array_type', $type);
            $button = $t->parse('output', (strpos($type, '*') === 0 ?
                'keyed-add-button' :
                'unkeyed-add-button'));
            $t->set_var('my_add_element_button', $button);
            $result = "";
            if ($type === '%select') {
                $result .= $this->_UI_get_conf_element($group,
                    $name . '[placeholder]', 'placeholder',
                    substr($type, 1), 'placeholder', $selectionArray,
                    true
                );
            }
            foreach ($val as $valkey => $valval) {
                $result .= $this->_UI_get_conf_element($group,
                    $name . '[' . $valkey . ']', $valkey,
                    substr($type, 1), $valval, $selectionArray,
                    true);
            }
            $t->set_var('my_elements', $result);
            // if the values are indexed numerically, add a class to the table
            // for identification. The UI code can take advantage of it
            if ($val === array_values($val)) {
                $t->set_var('arr_table_class_list', 'numerical_config_list');
            }

            return $t->parse('output', 'list-element');
        }
    }

    /**
     * Get a parsed config element based on group $group, name $name,
     * type $type, value to be shown $val and label $display_name to be shown
     * on the left based on language.
     *
     * @param  string $group          Configuration group.
     * @param  string $name           Configuration name on table.
     * @param  string $display_name   Configuration display name based on language.
     * @param  string $type           Configuration type such as select, text, textarea, @select, etc.
     * @param  string $val            Value of configuration
     * @param  mixed  $selectionArray Array of option of select element
     * @param  bool   $deletable      If configuration is deletable
     * @param  bool   $allow_reset    Allow set and unset of configuration
     * @return string
     */
    private function _UI_get_conf_element_2($group, $name, $display_name, $type, $val,
                                            $selectionArray = null, $deletable = false,
                                            $allow_reset = false)
    {
        global $LANG_CONFIG;

        $t = COM_newTemplate(CTL_core_templatePath($GLOBALS['_CONF']['path_layout'] . 'admin/config'));
        $t->set_file('element', 'config_element_2.thtml');

        $blocks = array(
            'delete-button', 'text-element', 'placeholder-element',
            'select-element', 'list-element', 'unset-param',
            'keyed-add-button', 'unkeyed-add-button', 'text-area',
            'validation_error_block',
        );
        foreach ($blocks as $block) {
            $t->set_block('element', $block);
        }

        $t->set_var('lang_restore', $LANG_CONFIG['restore']);
        $t->set_var('lang_enable', $LANG_CONFIG['enable']);
        $t->set_var('lang_add_element', $LANG_CONFIG['add_element']);

        $t->set_var('name', $name);
        $t->set_var('id_name', str_replace(array('[', ']'), array('_', ''), $name));
        $t->set_var('display_name', $display_name);

        // check tmp values
        if (isset($this->tmpValues[$group][$name])) {
            $val = $this->tmpValues[$group][$name];
        }

        if (!is_array($val)) {
            if (is_float($val)) {
                /**
                 * @todo FIXME: for Locales where the comma is the decimal
                 *              separator, patch output to a decimal point
                 *              to prevent it being cut off by COM_applyFilter
                 */
                $t->set_var('value', str_replace(',', '.', $val));
            } else {
                $t->set_var('value', htmlspecialchars($val));
            }
        }

        // if there is a error message to shown
        if (isset($this->validationErrors[$group][$name])) {
            $t->set_var('validation_error_message', $this->validationErrors[$group][$name]);
            $t->set_var('error_block', $t->parse('output', 'validation_error_block'));
            $t->set_var('error_class', ' input_error');
            $t->set_var('value', $this->validationErrorValues[$group][$name]);
        } else {
            $t->set_var('error_class', '');
            $t->set_var('error_block', '');
        }

        if ($deletable) {
            $t->set_var('delete', $t->parse('output', 'delete-button'));
        } else {
            if ($allow_reset) {
                $t->set_var('unset_link',
                    "(<a href=\"#{$name}\" class=\"unset_param\" title='"
                    . $LANG_CONFIG['disable'] . "'>X</a>)");
            }
            if (($a = strrchr($name, '[')) !== false) {
                //$on = substr($a, 1, -1);
                $o = str_replace(array('[', ']'), array('_', ''), $name);
            } else {
                $o = $name;
                //$on = $name;
            }
            /*  As of v2.2.0 Removed numeric check for config help which indicates a config option variable is an array.
                The only thing that uses config variables which are an array at the moment is Security Default Permissions for items like Articles, Dynamic Blocks and Autotags usage permissions.
                It was determined tooltip was needed since users where wondering what they are needed for.
                This should not affect anything else.

            if (!is_numeric($on)) {
                $this->_set_ConfigHelp($t, $group, $o);
            }
            */
            $this->_set_ConfigHelp($t, $group, $o);
        }
        // if $name is like "blah[0]", separate name and index
        $n = explode('[', $name);
        $index = null;
        $nc = count($n);
        if ($nc > 1) {
            $i = explode(']', $n[$nc - 1]);
            $index = $i[0];
        }
        if (!empty($index) && ($index === 'placeholder' || $display_name === 'skeleton')) {
            $t->set_var('hide_row', ' style="display:none;"');
        }

        $prefix = substr($type, 0, 1);
        if ($type === 'unset') {
            return $t->finish($t->parse('output', 'unset-param'));
        } elseif ($type === 'text') {
            return $t->finish($t->parse('output', 'text-element'));
        } elseif ($type === 'textarea') {
            return $t->finish($t->parse('output', 'text-area'));
        } elseif ($type === 'placeholder') {
            return $t->finish($t->parse('output', 'placeholder-element'));
        } elseif ($type === 'select') {
            // if $name is like "blah[0]", separate name and index
            $n = explode('[', $name);
            $name = $n[0];
            $type_name = $type . '_' . $name;
            if ($group === 'Core') {
                $fn = 'configmanager_' . $type_name . '_helper';
            } else {
                $fn = 'plugin_configmanager_' . $type_name . '_' . $group;
            }
            if (function_exists($fn)) {
                if ($index === null) {
                    $selectionArray = $fn();
                } else {
                    $selectionArray = $fn($index);
                }
            } elseif (is_array($selectionArray)) {
                // leave sorting to the function otherwise
                uksort($selectionArray, 'strcasecmp');
            }
            if (!is_array($selectionArray)) {
                return $t->finish($t->parse('output', 'text-element'));
            }

            $t->set_block('select-element', 'select-options', 'myoptions');
            foreach ($selectionArray as $sName => $sVal) {
                if (is_bool($sVal)) {
                    $t->set_var('opt_value', $sVal ? 'b:1' : 'b:0');
                } else {
                    $t->set_var('opt_value', $sVal);
                }
                $t->set_var('opt_name', $sName);
                $t->set_var('selected', ($val == $sVal ? 'selected="selected"' : ''));
                $t->parse('myoptions', 'select-options', true);
            }

            return $t->parse('output', 'select-element');
        } elseif ($prefix === '@') {
            $result = '';
            foreach ($val as $valkey => $valval) {
                $result .= $this->_UI_get_conf_element_2($group,
                    $name . '[' . $valkey . ']',
                    $display_name . '[' . $valkey . ']',
                    substr($type, 1), $valval, $selectionArray,
                    false);
            }

            return $result;
        } elseif ($prefix === '*' || $prefix === '%') {
            $t->set_var('arr_name', $name);
            $t->set_var('array_type', $type);
            $button = $t->parse('output', ($prefix === '*' ?
                'keyed-add-button' :
                'unkeyed-add-button'));
            $t->set_var('my_add_element_button', $button);
            $result = "";

            $base_type = str_replace(array('*', '%'), '', $type);
            if (in_array($base_type, array('select', 'text', 'placeholder'))) {
                $result .= $this->_UI_get_conf_element_2($group,
                    $name . '[placeholder]', 'skeleton',
                    substr($type, 1), 'placeholder', $selectionArray,
                    true);
            }

            if ($display_name === 'skeleton') {
                $val = array();
            }
            if (!is_array($val)) {
                $val = array();
            }

            foreach ($val as $valkey => $valval) {
                $result .= $this->_UI_get_conf_element_2($group,
                    $name . '[' . $valkey . ']', $valkey,
                    substr($type, 1), $valval, $selectionArray,
                    true
                );
            }
            $t->set_var('my_elements', $result);
            // if the values are indexed numerically, add a class to the div
            // for identification. The UI code can take advantage of it
            $t->set_var('arr_class_list', ($prefix === '%' ?
                'numerical_config_list' :
                'named_config_list'));

            return $t->parse('output', 'list-element');
        }
    }

    /**
     * This function takes $_POST input and evaluates it
     *
     * @param  array(string=>mixed) $change_array this is the $_POST array
     * @param  string               $group        Group name
     * @return array(string=>boolean)    this is the change_array
     */
    public function updateConfig($change_array, $group)
    {
        global $_TABLES;

        if ($group === 'Core') {
            /**
             * $_CONF['theme'] and $_CONF['language'] are overwritten with
             * the user's preferences in lib-common.php. Re-read values from
             * the database so that we're comparing the correct values below.
             */
            $value = DB_getItem($_TABLES['conf_values'], 'value', "group_name='Core' AND name='theme'");
            $this->config_array['Core']['theme'] = unserialize($value);
            $value = DB_getItem($_TABLES['conf_values'], 'value', "group_name='Core' AND name='language'");
            $this->config_array['Core']['language'] = unserialize($value);

            /**
             * Same with $_CONF['cookiedomain'], which is overwritten
             * in lib-sessions.php (if empty).
             */
            $value = DB_getItem($_TABLES['conf_values'], 'value', "group_name='Core' AND name='cookiedomain'");
            $this->config_array['Core']['cookiedomain'] = unserialize($value);

            /**
             * Same with $_CONF['doctype'], which is overwritten
             * with the theme's configuration in lib-common.php.
             */
            $value = DB_getItem($_TABLES['conf_values'], 'value', "group_name='Core' AND name='doctype'");
            $this->config_array['Core']['doctype'] = unserialize($value);
        }

        $this->_extract_permissible_conf($change_array, $group, $change_array['sub_group']);

        $pass_validation = array();
        $success_array = array();
        if (!is_array($this->validationErrors)) {
            $this->validationErrors = array();
        }

        foreach ($this->config_array[$group] as $param_name => $param_value) {
            if (array_key_exists($param_name, $change_array)) {
                // Sanitize input before validation of input begins
                $change_array[$param_name] =
                    $this->_validate_input($param_name, $group, $change_array[$param_name]);

                // we should avoid string conversion
                // see http://www.php.net/manual/en/language.types.string.php#language.types.string.conversion
                if (is_string($change_array[$param_name]) &&
                    !is_string($param_value)
                ) {
                    if (strcmp($change_array[$param_name], $param_value) !== 0 &&
                        $this->_validates($param_name, $group, $change_array[$param_name])
                    ) {
                        $pass_validation[$param_name] = $change_array[$param_name];
                    }
                } elseif (is_array($change_array[$param_name])) {
                    // if array such as mail settings
                    $_changed = false;
                    if (count($this->config_array[$group][$param_name]) != count($change_array[$param_name])) {
                        $_changed = true;
                    }
                    foreach ($change_array[$param_name] as $_param_name => $_param_value) {
                        if (!isset($this->config_array[$group][$param_name][$_param_name])) {
                            $_changed = true;
                        } elseif ($change_array[$param_name][$_param_name] != $this->config_array[$group][$param_name][$_param_name]) {
                            $_changed = true;
                        }
                        if ($_changed) {
                            if ($this->_validates($param_name . '[' . $_param_name . ']', $group, $change_array[$param_name][$_param_name], $change_array[$param_name])) {
                                $this->changedArray[$group][$param_name][$_param_name] = true;
                            }
                        }
                    }

                    if ($_changed) {
                        $pass_validation[$param_name] = $change_array[$param_name];
                    }
                } else {
                    if ($change_array[$param_name] != $param_value &&
                        $this->_validates($param_name, $group, $change_array[$param_name])
                    ) {
                        $pass_validation[$param_name] = $change_array[$param_name];
                    }
                }
            }
        }

        // after validation set the field
        if (empty($this->validationErrors)) {
            // only set if there is no validation error
            foreach ($pass_validation as $param => $val) {
                $this->set($param, $val, $group);
                $success_array[$param] = true;
            }
            $this->_post_configuration();
        } else {
            // temporally save the changed values
            foreach ($pass_validation as $param => $val) {
                $this->tmpValues[$group][$param] = $val;
            }
        }

        return $success_array;
    }

    /**
     * Extracts allowed conf from posted data. Used by updateConfig
     *
     * @param array(string=>mixed) $change_array this is the $_POST array
     * @param string               $group        Configuration group
     * @param int                  $sg_id        Subgroup id
     */
    private function _extract_permissible_conf(&$change_array, $group, $sg_id = null)
    {
        $permissible_conf = array();
        foreach ($this->conf_tab_arr[$group] as $sg => $tabs) {
            if ($sg_id && $sg_id != $sg) {
                continue;
            }

            foreach ($tabs as $tab_name => $tab) {
                foreach ($tab as $tab_id => $configs) {
                    $tab_ft = $this->conf_type['tab'][$group][$tab_name];
                    if (SEC_inGroup('Root') || SEC_hasRights($tab_ft)) {
                        $permissible_conf = array_merge(array_intersect_key($change_array, $configs), $permissible_conf);
                    }
                }
            }
        }
        $change_array = array_intersect_key($change_array, $permissible_conf);
    }

    /**
     * Input validation
     *
     * @param  string $config
     * @param  string $group
     * @param  mixed  $input_val
     * @return mixed
     */
    private function _validate_input($config, $group, &$input_val)
    {
        if (is_array($input_val)) {
            $r = array();
            $is_num = true;
            $max_key = -1;
            foreach ($input_val as $key => $val) {
                if ($key !== 'placeholder' && $key !== 'nameholder') {
                    $r[$key] = $this->_validate_input($config, $group, $val);
                    if (is_numeric($key)) {
                        if ($key > $max_key) {
                            $max_key = $key;
                        }
                    } else {
                        $is_num = false;
                    }
                }
            }
            if ($is_num && ($max_key >= 0) && ($max_key + 1 != count($r))) {
                // re-number keys
                $r2 = array();
                foreach ($r as $val) {
                    $r2[] = $val;
                }
                $r = $r2;
            }
        } else {
            $r = COM_stripslashes($input_val);
            // Boolean default check
            // Numeric check
            // String Sanitize
            if ($r === 'b:0' || $r === 'b:1') {
                $r = ($r === 'b:1');
            } elseif (is_numeric($r) && $this->_validate_numeric($config, $group)) {
                $r = $r + 0;
            } else {
                $r = $this->_sanitize_string($config, $group, $input_val);
            }
        }

        return $r;
    }

    /**
     * Returns sanitized string.
     *
     * @param  string $config Configuration variable
     * @param  string $group  Configuration group
     * @param  mixed  $input_val
     * @return string
     */
    private function _sanitize_string($config, $group, $input_val)
    {
        global $_CONF_VALIDATE;

        if (isset($_CONF_VALIDATE[$group][$config]) &&
            !empty($_CONF_VALIDATE[$group][$config])
        ) {
            $default_strip_tags = true;
            foreach ($_CONF_VALIDATE[$group][$config] as $index => $validator) {
                if ($index === 'sanitize') {
                    if (is_array($validator)) {
                        $rule_type = $validator[0];
                    } else {
                        $rule_type = $validator;
                    }

                    switch ($rule_type) {
                        case 'none':
                            $default_strip_tags = false;
                            break;

                        case 'noTags':
                            $input_val = GLText::stripTags($input_val);
                            $default_strip_tags = false;
                            break;

                        case 'approvedTags':
                            $input_val = COM_checkHTML($input_val);
                            $default_strip_tags = false;
                            break;

                        case 'allTags':
                            $default_strip_tags = false;
                            break;

                        default:
                            break;
                    }
                }
            }
            if ($default_strip_tags) {
                $input_val = GLText::stripTags($input_val);
            }
        }

        return $input_val;
    }

    /**
     * Returns true if configuration field should be numeric.
     *
     * @param  string $config Configuration variable
     * @param  string $group  Configuration group
     * @return bool           True if numeric
     */
    private function _validate_numeric($config, $group)
    {
        global $_CONF_VALIDATE;

        if (isset($_CONF_VALIDATE[$group][$config]) &&
            !empty($_CONF_VALIDATE[$group][$config])
        ) {
            foreach ($_CONF_VALIDATE[$group][$config] as $index => $validator) {
                if ($index === 'rule') {
                    if (is_array($validator)) {
                        $rule_type = $validator[0];
                    } else {
                        $rule_type = $validator;
                    }

                    return in_array($rule_type, array('numeric', 'range', 'decimal', 'comparison'));
                }
            }
        }

        // No rule found then return true as validation will happen the old way by just using is_numeric
        return true;
    }

    /**
     * Returns true if configuration field pass given validation rule.
     *
     * @param string $config       Configuration variable
     * @param string $group        Configuration group
     * @param mixed  $value        Submitted value
     * @param mixed  $relatedValue value that related such as mail settings
     * @return boolean             True if there are no errors
     */
    private function _validates($config, $group, &$value, &$relatedValue = null)
    {
        global $_CONF_VALIDATE, $LANG_VALIDATION;

        $_validator = Validator::getInstance();

        if (isset($_CONF_VALIDATE[$group][$config]) &&
            !empty($_CONF_VALIDATE[$group][$config])
        ) {
            $default = array(
                'rule' => 'blank',
            );

            foreach ($_CONF_VALIDATE[$group][$config] as $index => $validator) {
                if ($index !== 'sanitize') {
                    if (!is_array($validator)) {
                        if ($index === 'message' && is_string($validator)) {
                            continue;
                        }

                        $validator = array('rule' => $validator);
                    } else {
                        if ($index === 'rule') {
                            $validator = array('rule' => $validator);
                        }
                    }
                    if (isset($_CONF_VALIDATE[$group][$config]['message']) &&
                        is_string($_CONF_VALIDATE[$group][$config]['message'])
                    ) {
                        $validator['message'] = $_CONF_VALIDATE[$group][$config]['message'];
                        unset($_CONF_VALIDATE[$group][$config]['message']);
                    }
                    $validator = array_merge($default, $validator);

                    if (isset($validator['message'])) {
                        $message = $validator['message'];
                    } elseif (is_string($validator['rule']) && isset($LANG_VALIDATION[$validator['rule']])) {
                        $message = $LANG_VALIDATION[$validator['rule']];
                    } elseif (is_array($validator['rule']) && isset($LANG_VALIDATION[$validator['rule'][0]])) {
                        $message = $LANG_VALIDATION[$validator['rule'][0]];
                    } else {
                        $message = $LANG_VALIDATION['default'];
                    }

                    if (is_array($validator['rule'])) {
                        $rule = $validator['rule'][0];
                        unset($validator['rule'][0]);
                        $ruleParams = array_merge(array($value), array_values($validator['rule']));
                    } else {
                        $rule = $validator['rule'];
                        $ruleParams = array($value);
                    }

                    $valid = true;
                    $custom_function = 'custom_validation_' . strtolower($rule);
                    if (function_exists($custom_function)) {
                        $ruleParams[] = $validator;
                        $ruleParams[0] = array($config => $ruleParams[0]);

                        if (is_array($relatedValue) && !empty($relatedValue)) {
                            $ruleParams[] = $relatedValue;
                        }

                        $valid = $custom_function($rule, $ruleParams);
                    } elseif (method_exists($_validator, $rule)) {
                        $valid = $_validator->dispatchMethod($rule, $ruleParams);
                    } elseif (!is_array($validator['rule'])) {
                        $valid = preg_match($rule, $value);
                    }

                    if (!$valid || (is_string($valid) && strlen($valid) > 0)) {
                        if (is_string($valid) && strlen($valid) > 0) {
                            $validator['message'] = $valid;
                        } elseif (!isset($validator['message'])) {
                            $validator['message'] = $message;
                        }

                        $this->validationErrors[$group][$config] = $validator['message'];
                        $this->validationErrorValues[$group][$config] = $value;

                        return false;
                    }
                }
            } // end foreach
            return $valid;
        } // end if

        return true;
    }

    /**
     * Builds configuration menu
     *
     * @param  string $conf_group Configuration group
     * @param  int    $sg         Configuration subgroup
     * @return string
     */
    private function _UI_configmanager_menu($conf_group, $sg = 0)
    {
        global $_CONF, $LANG_ADMIN, $LANG_CONFIG, $LANG_configsections, $LANG_configsubgroups;

        $retval = COM_startBlock($LANG_CONFIG['sections'], '',
            COM_getBlockTemplate('configmanager_block', 'header'));
        $link_array = array();

        $groups = $this->_get_groups();
        if (count($groups) > 0) {
            foreach ($groups as $group) {
                if (empty($LANG_configsections[$group]['label'])) {
                    $group_display = ucwords($group);
                } else {
                    $group_display = $LANG_configsections[$group]['label'];
                }
                // Create a menu item for each config group - disable the link for the current selected one
                if ($this->flag_version_2 == true) {
                    if ($conf_group == $group) {
                        $link = "<li class=\"configoption_off\">$group_display</li>";
                    } else {
                        $link = "<li class=\"configoption\"><a href=\"#\" onclick='open_group(\"$group\");return false;'>$group_display</a></li>";
                    }
                } else {
                    if ($conf_group == $group) {
                        $link = "<div>$group_display</div>";
                    } else {
                        $link = "<div><a href=\"#\" onclick='open_group(\"$group\");return false;'>$group_display</a></div>";
                    }
                }
                if ($group === 'Core') {
                    $retval .= $link;
                } else {
                    $link_array[$group_display] = $link;
                }
            }
        }

        uksort($link_array, 'strcasecmp');
        foreach ($link_array as $link) {
            $retval .= $link;
        }

        if ($this->flag_version_2 == true) {
            $retval .= '<li class="configoption"><a href="' . $_CONF['site_admin_url'] . '">'
                . $LANG_ADMIN['admin_home'] . '</a></li>';
        } else {
            $retval .= '<div><a href="' . $_CONF['site_admin_url'] . '">'
                . $LANG_ADMIN['admin_home'] . '</a></div>';
        }
        $retval .= COM_endBlock(COM_getBlockTemplate('configmanager_block', 'footer'));

        // Now display the sub-group menu for the selected config group
        if (empty($LANG_configsections[$conf_group]['title'])) {
            $subgroup_title = ucwords($conf_group);
        } else {
            $subgroup_title = $LANG_configsections[$conf_group]['title'];
        }
        $retval .= COM_startBlock($subgroup_title, '',
            COM_getBlockTemplate('configmanager_subblock', 'header'));

        $subGroups = $this->_get_sgroups($conf_group);
        if (count($subGroups) > 0) {
            $i = 0;
            foreach ($subGroups as $sgName => $sGroup) {
                if (isset($LANG_configsubgroups[$conf_group][$sgName])) {
                    $group_display = $LANG_configsubgroups[$conf_group][$sgName];
                } elseif (isset($LANG_configsubgroups[$conf_group][$sGroup])) {
                    $group_display = $LANG_configsubgroups[$conf_group][$sGroup];
                } else {
                    $group_display = $sgName;
                }
                // Create a menu item for each sub config group - disable the link for the current selected one
                if ($this->flag_version_2 == true) {
                    if ($sGroup == $sg) {
                        $retval .= "<li class=\"configoption_off\">$group_display</li>";
                    } else {
                        $retval .= "<li class=\"configoption\"><a href=\"#\" onclick='open_subgroup(\"$conf_group\",\"$sGroup\");return false;'>$group_display</a></li>";
                    }
                } else {
                    if ($sGroup == $sg) {
                        $retval .= "<div>$group_display</div>";
                    } else {
                        $retval .= "<div><a href=\"#\" onclick='open_subgroup(\"$conf_group\",\"$sGroup\");return false;'>$group_display</a></div>";
                    }
                }
                $i++;
            }
        }
        $retval .= COM_endBlock(COM_getBlockTemplate('configmanager_block', 'footer'));

        return $retval;
    }

    /**
     * Build JSON for autocomplete
     *
     * @return string JS variable in string
     */
    private function _UI_autocomplete_data()
    {
        global $LANG_configsections, $LANG_confignames, $LANG_fs, $LANG_tab, $LANG_CONFIG;

        $permitted_groups = $this->_get_groups();
        $retval = array();

        foreach ($this->conf_type['tree'] as $group => $subgroups) {
            if (!in_array($group, $permitted_groups)) {
                continue;
            }

            foreach ($subgroups as $sg => $tabs) {
                foreach ($tabs as $tab => $tab_ft) {
                    if (!SEC_inGroup('Root') && !SEC_hasRights($tab_ft)) {
                        continue;
                    }

                    // Figure out if tab name is set, if not assume old plugin and default the name
                    if (isset($LANG_tab[$group][$tab])) {
                        $tab_label = $LANG_tab[$group][$tab];
                    } else {
                        $tab_label = $LANG_CONFIG['default_tab_name'];
                    }

                    foreach ($this->conf_tab_arr[$group][$sg][$tab] as $tab_id => $configs) {
                        foreach ($configs as $conf => $conf_var) {
                            // Check to see if label exists for config name
                            if (array_key_exists($conf, $LANG_confignames[$group])) {
                                $label = $LANG_confignames[$group][$conf];
                            } else {
                                // Maybe a fieldset, check to see if fieldset label exits
                                if (array_key_exists($conf, $LANG_fs[$group])) {
                                    $label = $LANG_fs[$group][$conf];
                                } else {
                                    // No label found
                                    // Maybe config value type is hidden, so skip
                                    continue;
                                }
                            }

                            if (is_array($conf_var)) {
                                foreach ($conf_var as $_conf_var) {
                                    $retval["$group.$tab.$conf.$_conf_var"] = '{' .
                                        'value: "' . $conf . '[' . $_conf_var . ']", ' .
                                        'label: "' . str_replace('"', '\"', $label) . '[' . $_conf_var . ']", ' .
                                        'category: "' .
                                        str_replace('"', '\"', $LANG_configsections[$group]['label']) . ' &raquo; ' .
                                        str_replace('"', '\"', $tab_label) . '", ' .
                                        'tab_id: ' . $tab_id . ', ' .
                                        'subgroup: ' . $sg . ', ' .
                                        'group: "' . $group . '"' .
                                        '}';
                                }
                            } else {
                                $retval["$group.$tab.$conf"] = '{' .
                                    'value: "' . $conf . '", ' .
                                    'label: "' . str_replace('"', '\"', $label) . '", ' .
                                    'category: "' .
                                    str_replace('"', '\"', $LANG_configsections[$group]['label']) . ' &raquo; ' .
                                    str_replace('"', '\"', $tab_label) . '", ' .
                                    'tab_id: ' . $tab_id . ', ' .
                                    'subgroup: ' . $sg . ', ' .
                                    'group: "' . $group . '"' .
                                    '}';
                            }
                        }
                    }
                }
            }
        }
        $retval = implode(',', $retval);

        return "var autocomplete_data = [{$retval}];";
    }

    /**
     * Set image spinner path in javascript variable
     *
     * @return string JS variable in string
     */
    private function _UI_js_image_spinner()
    {
        $image = $GLOBALS['_CONF']['layout_url'] . '/jquery_ui/images/ui-anim_basic_16x16.gif';

        return 'var imgSpinner = "' . $image . '";';
    }

    /**
     * Helper function: Fix escaped SQL requests for MS SQL, if necessary
     *
     * @param  string $sql
     */
    private function _DB_escapedQuery($sql)
    {
        global $_DB, $_DB_dbms;

        if ($_DB_dbms === 'pgsql') {
            $sql = str_replace("\\'", "''", $sql);
            $sql = str_replace('\\"', '"', $sql);
            $_DB->dbQuery($sql, 0, 1);
        } else {
            DB_query($sql);
        }
    }

    /**
     * Helper function: Set the URL to the help section for a config option
     *
     * @param    Template $t      Template object
     * @param    string   $group  'Core' or plugin name
     * @param    string   $option name of the config option
     */
    private function _set_ConfigHelp(&$t, $group, $option)
    {
        global $_SCRIPTS;
        static $docUrl;

        if (!isset($docUrl)) {
            $docUrl = array();
        }

        $configText = PLG_getConfigTooltip($group, $option);
        if (empty($configText)) {
            if ($group === 'Core') {
                $configText = null;
            }
            if (empty($docUrl[$group])) {
                if ($group === 'Core') {
                    if (!empty($GLOBALS['_CONF']['site_url']) && !empty($GLOBALS['_CONF']['path_html'])) {
                        $url = COM_getDocumentUrl('docs', 'config.html');
                    } else {
                        $url = 'https://www.geeklog.net/docs/english/config.html';
                    }
                    $docUrl['Core'] = $url;
                } else { // plugin
                    $docUrl[$group] = PLG_getDocumentationUrl($group, 'config');
                }
                $_SCRIPTS->setJavaScript('var glConfigDocUrl = "' . $docUrl[$group] . '";', true);
            }
            $descUrl = $docUrl[$group];

            if (!empty($descUrl)) {
                if (strpos($descUrl, '#') === false) {
                    $descUrl .= '#desc_' . $option;
                }

                $t->set_var('doc_url', $descUrl);

                if ($this->flag_version_2 == true) {
                    // Does hack need to be used?
                    if (gettype($configText) == "NULL") {
                        $t->set_var('doc_link',
                            '(<a href="javascript:void(0);" id="desc_' . $option . '" class="tooltip">?</a>)');
                    } else {
                        $t->set_var('doc_link',
                            '(<a href="javascript:void(0);" id="desc_' . $option . '">?</a>)');
                    }
                } else {
                    // Does hack need to be used?
                    if (gettype($configText) == "NULL") {
                        $t->set_var('doc_link',
                            '(<a href="' . $descUrl . '" target="help" class="tooltip">?</a>)');
                    } else {
                        $t->set_var('doc_link',
                            '(<a href="' . $descUrl . '" target="help">?</a>)');
                    }
                }
            }
        } else {
            $t->set_var('doc_url', '');
            $retval = "(" . COM_getTooltip("?", $configText, '', $option, 'information') . ")";
            $t->set_var('doc_link', $retval);
        }
    }

    /**
     * Get features that has ft_name like 'config%'.
     * Used by lib-common to declare $_CONF_FT
     *
     * @return array features that has ft_name like 'config%'
     */
    public function _get_config_features()
    {
        global $_TABLES;

        if (is_null($this->conf_ft_arr)) {
            $result = DB_query("SELECT ft_name FROM {$_TABLES['features']} WHERE ft_name LIKE 'config.%'");
            $this->conf_ft_arr = array();
            $numRows = DB_numRows($result);
            if ($numRows > 0) {
                for ($i = 0; $i < $numRows; $i++) {
                    $A = DB_fetchArray($result, false);
                    $this->conf_ft_arr[$i] = $A['ft_name'];
                }
            }
        }

        return $this->conf_ft_arr;
    }
}
