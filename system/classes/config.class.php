<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
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

class config {
    /**
     * Path to db-config.php file
     * @var string
     */
    var $dbconfig_file;
    
    /**
     * Array of configurations
     * @var array
     */
    var $config_array;
    
    /**
     * Array of configuration tabs, used by autocomplete
     * @var array
     */
    var $conf_tab_arr;
    
    /**
     * Array of configuration features (security rights)
     * @var array
     */
    var $conf_ft_arr;
    
    /**
     * Array of configuration types
     * @var array
     */
    var $conf_type;
    
    /**
     * Whether support new theme format for the later Geeklog 2.0 or not
     * @var boolean
     */
    var $flag_version_2;
    
    /**
     * List of validation rules. Append entries for validation as 
     * ('field_name' => '/^perl_compat_regexp$/') that have to match
     * with preg_match(). Use these rules with config::_validates()
     *
     * @var array
     * @access public
     */
	var $validate = array();

    /**
     * List of validation errors.
     *
     * @var array
     * @access public
     */
	var $validationErrors = array();
    
    /**
     * Values that failed validation
     * 
     * @var array
     * @access public
     */
    var $validationErrorValues = array();
    
    /**
     * Changed values that pass the validation.
     * If validationErrors is not empty, changed values should be saved
     * for later submission
     * 
     * @var array
     * @access public
     */
    var $tmpValues = array();
    
    /**
     * Changed configuration array (such as mail settings) that pass the validation.
     * If validationErrors is not empty, changed values should be saved
     * for later submission
     * 
     * @var array
     * @access public
     */
    var $changedArray = array();
    
    /**
     * Constructor
     */
    function __construct()
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
     *    @param string group_name This is simply the group name that this
     *                             config object will control - for the main gl
     *                             settings this is 'Core'
     *
     *    @return config           The newly created or referenced config object
     */
    public static function &get_instance()
    {
        static $instance;

        if (!$instance) {
            $instance = new config();
        }

        return $instance;
    }

    /**
     * For PHP 4
     */
    function config()
    {
        $this->__construct();
    }

    /**
     * This method sets the secure configuration file (database related
     * settings) for the configuration class to read. This should only need to
     * be called for the 'Core' group. It also must be called before
     * load_baseconfig()
     *
     * @param string sf        The filename and path of the secure db settings
     */

    function set_configfile($sf)
    {
        $this->dbconfig_file = $sf;
    }

    /**
     * This method reads the secure configuration file and loads
     * lib-database.php. This needs to be called in the 'Core' group before
     * &init_config() can be used. It only needs to be called once
     */

    function load_baseconfig()
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
     * @return array(string => mixed)      This is a reference to the
     *                                     config array
     */
    function &initConfig()
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
            if ($row['type'] != 'tab' && $row['tab'] == '' && ($row['group_name'] != $curr_group_name || $row['subgroup'] != $curr_subgroup)) {
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
            if ($row[3] == 'tab') {
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
            if ($row[3] == 'subgroup') {
                $this->conf_type['subgroup'][$row[2]][$row[0]] = $row[0];
                continue;
            }

            // group the fieldset type
            if ($row[3] == 'fieldset') {
                $this->conf_type['fieldset'][$row[2]][$row[0]] = $row[0];
            //    continue;
            }               
            
            if ($row[1] !== 'unset') {
                if (!array_key_exists($row[2], $this->config_array) ||
                    !array_key_exists($row[0], $this->config_array[$row[2]])) {
                    $value = @unserialize($row[1]);
                    if (($value === false) && ($row[1] != $false_str)) {
                        if (function_exists('COM_errorLog')) {
                            COM_errorLog("Unable to unserialize {$row[1]} for {$row[2]}:{$row[0]}");
                        }
                    } else {
                        $this->config_array[$row[2]][$row[0]] = $value;
                        
                        if ( strpos($row[3], '@') === 0 ) { // if @
                            if ( is_array($value) && !empty($value) ) {
                                $this->conf_tab_arr[$row[2]][$row[4]]
                                [$tabs[$row[2]][$row[4]][$row[5]]][$row[5]][$row[0]] = array_keys($value);
                            }
                        } else {
                            $this->conf_tab_arr[$row[2]][$row[4]]
                            [$tabs[$row[2]][$row[4]][$row[5]]][$row[5]][$row[0]] = $row[0];
                        }
                    }
                }
            } else {
                // set to autocomplete only
                $this->conf_tab_arr[$row[2]][$row[4]]
                [$tabs[$row[2]][$row[4]][$row[5]]][$row[5]][$row[0]] = $row[0];
            }
        }
        $this->_post_configuration();

        return $this->config_array;
    }

    /**
     * Get configurations for particular group.
     * 
     * @param string        $group  Group name
     * @return bool|array           Array of configurations for specified group
     *                              or returns false if group doesn't exist
     */
    function &get_config($group)
    {
        $retval = false;

        if (array_key_exists($group, $this->config_array)) {

            // an ugly little hack to ensure backward compatibility ...
            if ($group == 'Core') {
                global $_DB_mysqldump_path;

                $_DB_mysqldump_path = $this->config_array[$group]['mysqldump_path'];
            }

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
    function group_exists($group)
    {
        return array_key_exists($group, $this->config_array);
    }

    /**
     * This method sets a configuration variable to a value in the database
     * and in the current array. If the variable does not already exist,
     * nothing will happen.
     *
     * @param   string  $name        Name of the config parameter to set
     * @param   mixed   $value       The value to set the config parameter to
     * @return  void
     */
    function set($name, $value, $group='Core')
    {
        global $_TABLES;

        $escaped_val = addslashes(serialize($value));
        $escaped_name = addslashes($name);
        $escaped_grp = addslashes($group);
        $sql = "UPDATE {$_TABLES['conf_values']} " .
               "SET value = '{$escaped_val}' WHERE " .
               "name = '{$escaped_name}' AND group_name = '{$escaped_grp}'";
        $this->_DB_escapedQuery($sql);
        $this->config_array[$group][$name] = $value;
        $this->_post_configuration();
    }

    /**
     * This method sets the default of a configuration variable to a value in
     * the database but not in the current array.
     * If the variable does not already exist, nothing will happen.
     *
     * @param   string $name        Name of the config parameter to set
     * @param   mixed  $value       The value to set the config parameter to
     * @param   string $group       Config group name ('Core' or plugin name)
     * @return  void
     */
    function set_default($name, $value, $group = 'Core')
    {
        global $_TABLES;

        $escaped_val = addslashes(serialize($value));
        $escaped_name = addslashes($name);
        $escaped_grp = addslashes($group);
        $sql = "UPDATE {$_TABLES['conf_values']} " .
               "SET default_value = '{$escaped_val}' WHERE " .
               "name = '{$escaped_name}' AND group_name = '{$escaped_grp}'";
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
    function restore_param($name, $group, $sg = null, $tab_id = null)
    {
        global $_TABLES;
        
        // check if current user other than Root has access to
        $tab_name = $this->_get_tab_name($group, $tab_id);
        $ft = $this->conf_type['tab'][$group][$tab_name];
        if ( !SEC_inGroup('Root') && !SEC_hasRights($ft) ) {
            return false;
        }

        $escaped_name = addslashes($name);
        $escaped_grp = addslashes($group);

        $result = DB_query("SELECT value, default_value FROM {$_TABLES['conf_values']} WHERE name = '{$escaped_name}' AND group_name = '{$escaped_grp}'");
        list($value, $default_value) = DB_fetchArray($result);

        $sql = "UPDATE {$_TABLES['conf_values']} ";
        if ($value == 'unset') {
            $default_value = addslashes($default_value);
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
    function unset_param($name, $group, $sg = null, $tab_id = '')
    {
        global $_TABLES;
        
        // check if current user other than Root has access to
        $tab_name = $this->_get_tab_name($group, $tab_id);
        $ft = $this->conf_type['tab'][$group][$tab_name];
        if ( !SEC_inGroup('Root') && !SEC_hasRights($ft) ) {
            return false;
        }

        $escaped_name = addslashes($name);
        $escaped_grp = addslashes($group);
        $default_value = DB_getItem($_TABLES['conf_values'], 'default_value',
                "name = '{$escaped_name}' AND group_name = '{$escaped_grp}'");
        $sql = "UPDATE {$_TABLES['conf_values']} SET value = 'unset'";
        if (substr($default_value, 0, 6) == 'unset:') {
            $default_value = addslashes(substr($default_value, 6));
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
     *
     *    If the configuration variable is an array, prefix this string with
     *    '@' if the administrator should NOT be able to add or remove keys
     *    '*' if the administrator should be able to add named keys
     *    '%' if the administrator should be able to add numbered keys
     *    These symbols can be repeated like such: @@text if the configuration
     *    variable is an array of arrays of text.
     *    The base variable types are:
     *    'text'    textbox displayed     string  value stored
     *    'select'  selectbox displayed   string  value stored
     *    'hidden'  no display            string  value stored
     *
     * @param string  $subgroup          subgroup of the variable
     *                                   (the second row of tabs on the user interface)
     * @param string  $fieldset          the fieldset to display the variable under
     * @param array   $selection_array   possible selections for the 'select' type
     *                                   this MUST be passed if you use the 'select'
     *                                   type
     * @param int     $sort              sort rank on the user interface (ascending)
     *
     * @param boolean $set               whether or not this parameter is set to config_array property
     * @param string  $group             group of the variable
     * @param string  $tab               the tab to display the variable under
     */
    function add($param_name, $default_value, $type, $subgroup, $fieldset=null,
         $selection_array=null, $sort=0, $set=true, $group='Core', $tab=null)
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
                       serialize($default_value)
                      );

        $columns = 'name, value, type, subgroup, group_name, selectionArray, sort_order, fieldset, default_value';

        // special handling of $tab for backward compatibility
        if ($tab !== null) {
            $columns .= ', tab';
            $Qargs[9] = $tab;
        }
        $Qargs = array_map('addslashes', $Qargs);

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
     * Permanently deletes a parameter
     * @param string $param_name This is the name of the parameter to delete
     * @param string $group      Configuraton group name      
     */
    function del($param_name, $group)
    {
        DB_delete($GLOBALS['_TABLES']['conf_values'],
                  array('name', 'group_name'),
                  array(addslashes($param_name), addslashes($group)));
        unset($this->config_array[$group][$param_name]);
    }

    /**
     * Gets extended (GUI related) information from the database
     * @param string subgroup            filters by subgroup
     * @return array(string => string => array(string => mixed))
     *    Array keys are fieldset => parameter named => information array
     */
    function _get_extended($subgroup, $group)
    {
        global $_TABLES, $LANG_confignames, $LANG_configselects;

        $q_string = "SELECT name, type, selectionArray, "
            . "tab, value, default_value, fieldset FROM {$_TABLES['conf_values']}" .
            " WHERE group_name='{$group}' AND subgroup='{$subgroup}' " .
            " AND (type <> 'tab' AND type <> 'subgroup') " .
            " ORDER BY tab,fieldset,sort_order ASC";

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

            if ($cur[3] == '') {$cur[3] = 0;}  // If tab is null then old plugin so set default tab

            if (substr($cur[5], 0, 6) == 'unset:') {
                $cur[5] = true;
            } else {
                $cur[5] = false;
            }
            $res[$cur[3]][$cur[0]] =
                array('display_name' =>
                      (array_key_exists($cur[0], $LANG_confignames[$group]) ?
                       $LANG_confignames[$group][$cur[0]]
                       : $cur[0]),
                      'type' =>
                      (($cur[4] == 'unset') ?
                       'unset' : $cur[1]),
                      'selectionArray' =>
                      (($cur[2] != -1) ?
                       //isset($LANG_configselects[$group][$cur[2]]) : null),
                       $LANG_configselects[$group][$cur[2]] : null),
                      'value' =>
                      (($cur[4] == 'unset') ?
                       'unset' : unserialize($cur[4])),
                      'fieldset' => $cur[6], 
                      'reset' => $cur[5]);
        }

        return $res;
    }

    /**
     * Changes any config settings that depend on other configuration settings.
     * Called by config::initConfig and config::set
     * 
     * @return voif
     */
    function _post_configuration()
    {
        global $_USER;

        if (empty($_USER['theme'])) {
            if (! empty($this->config_array['Core']['theme'])) {
                $theme = $this->config_array['Core']['theme'];
            }
        } else {
            $theme = $_USER['theme'];
        }

        if (! empty($theme)) {
            if (! empty($this->config_array['Core']['path_themes'])) {
                $this->config_array['Core']['path_layout'] = $this->config_array['Core']['path_themes'] . $theme . '/';
            }
            if (! empty($this->config_array['Core']['site_url'])) {
                $this->config_array['Core']['layout_url'] = $this->config_array['Core']['site_url'] . '/layout/' . $theme;
            }
        }

        $methods = array('standard', 'openid', '3rdparty', 'oauth');
        $methods_disabled = 0;
        foreach ($methods as $m) {
            if (isset($this->config_array['Core']['user_login_method'][$m]) &&
                    !$this->config_array['Core']['user_login_method'][$m]) {
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
     * @return array Array of configuraton groups.
     */
    function _get_groups()
    {
        global $_TABLES, $_RIGHTS;
        
        $groups = array_keys($this->config_array);
        $num_groups = count($groups);
        for ($i = 0; $i < $num_groups; $i++) {
            $g = $groups[$i];
            // Only collect plugins that are enabled
            if ($g != 'Core') {
                $enabled = DB_getItem($_TABLES['plugins'], 'pi_enabled',
                                      "pi_name = '$g'");
                if (isset($enabled) && ($enabled == 0)) {
                    unset($groups[$i]);
                    continue;
                }
            }
            
            // check if current user other than Root has access to
            $tabs = array_values($this->conf_type['tab'][$g]);
            if ( !SEC_inGroup('Root') && !SEC_hasRights($tabs, 'OR') ) {
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
    function _get_sgroups($group)
    {
        global $_TABLES;

        $q_string = "SELECT name,subgroup FROM {$_TABLES['conf_values']} WHERE "
                  . "type = 'subgroup' AND group_name = '$group' "
                  . "ORDER BY subgroup";
        $retval = array();
        
        $res = DB_query($q_string);
        while ($row = DB_fetchArray($res)) {
            // check if current user has access to current subgroup
            $tabs = array_values($this->conf_type['tree'][$group][$row['subgroup']]);
            if ( !SEC_inGroup('Root') && !SEC_hasRights($tabs, 'OR') ) {
                continue;
            }
            $retval[$row['name']] = $row['subgroup'];
        }

        return $retval;
    }
    
    
    /**
     * Get tab name based on sepecified group name and tab id.
     * 
     * @param string $group Group name
     * @param int $tab_id tab id
     */
    function _get_tab_name($group, $tab_id) {
        global $_TABLES;
        
        return DB_getItem($_TABLES['conf_values'], 'name',
                    "type = 'tab' AND tab = $tab_id AND group_name = '$group'");
        
    }
    
    /**
     * Get fieldset name based on sepecified tab id.
     * 
     * @param string $tab_id tab id
     * @param int $fs_id fieldset id
     */
    function _get_fs_name($tab_id, $fs_id) {
        global $_TABLES;
        
        return DB_getItem($_TABLES['conf_values'], 'name',
                    "type = 'fieldset' AND fieldset = $fs_id AND tab = '$tab_id'");
        
    }

    /**
     * This function is responsible for creating the configuration GUI
     * 
     * @oaram string $grp     This is the group name to load the gui for.
     * @param string sg       This is the subgroup name to load the gui for.
     *                        If nothing is passed, it will display the first
     *                        (alpha) subgroup.
     * @param mixed  $change_result
     *                        This is an array of what changes were made to the
     *                        configuration - if it is passed, it will display
     *                        the "Changes" message box.
     */
    function get_ui($grp, $sg='0', $change_result=null)
    {
        global $_CONF, $LANG_CONFIG, $LANG_configsubgroups, $LANG_tab, $LANG_fs,
            $_SCRIPTS, $LANG01;

        if(!array_key_exists($grp, $LANG_configsubgroups)) {
            $LANG_configsubgroups[$grp] = array();
        }
        
        // denied users that don't have access to configuration
        $groups = $this->_get_groups();
        if (empty($groups)) {
            return config::_UI_perm_denied();
        }
        
        if (!isset($sg) OR empty($sg)) {
            $sg = '0';
            
            // get default subgroup for non Root user
            if ( !SEC_inGroup('Root') ) {
                $default_sg = $this->_get_sgroups($grp);
                if ( !empty($default_sg) ) {
                    $default_sg = array_values($default_sg);
                    $sg = $default_sg[0];
                } else {
                    return config::_UI_perm_denied();
                }
            }
        }
        
        $t = COM_newTemplate($_CONF['path_layout'] . 'admin/config');
        $t->set_file(array('main' => 'configuration.thtml',
                           'menugroup' => 'menu_element.thtml'));

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
            $t->set_var('search_configuration_value', $_POST['search-configuration-cached']);
        } else {
            $t->set_var('search_configuration_value', '');
        }
        if (isset($_POST['tab-id-cached'])) {
            $t->set_var('tab_id_value', $_POST['tab-id-cached']);
        } else {
            $t->set_var('tab_id_value', '');
        }

        $t->set_var('lang_save_changes', $LANG_CONFIG['save_changes']);
        $t->set_var('lang_reset_form', $LANG_CONFIG['reset_form']);
        
        $t->set_var('open_group', $grp);

        $outerloopcntr = 1;
        if (count($groups) > 0) {
            $t->set_block('menugroup', 'subgroup-selector', 'subgroups');
            foreach ($groups as $group) {
                $t->set_var("select_id", ($group === $grp ? 'id="current"' : ''));
                $t->set_var("group_select_value", $group);
                $t->set_var("group_display", ucwords($group));
                $subgroups = $this->_get_sgroups($group);
                $innerloopcntr = 1;
                foreach ($subgroups as $sgname => $sgroup) {
                    if ($grp == $group AND $sg == $sgroup) {
                        $t->set_var('group_active_name', ucwords($group));
                        if (isset($LANG_configsubgroups[$group][$sgname])) {
                            $t->set_var('subgroup_active_name',
                                    $LANG_configsubgroups[$group][$sgname]);
                        } else if (isset($LANG_configsubgroups[$group][$sgroup])) {
                            $t->set_var('subgroup_active_name',
                                    $LANG_configsubgroups[$group][$sgroup]);
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
                    if ($innerloopcntr == 1) {
                        $t->parse('subgroups', "subgroup-selector");
                    } else {
                        $t->parse('subgroups', "subgroup-selector", true);
                    }
                    $innerloopcntr++;
                }
                $t->set_var('cntr',$outerloopcntr);
                $t->parse("menu_elements", "menugroup", true);
                $outerloopcntr++;
            }
        } else {
            $t->set_var('hide_groupselection','none');
        }

        $t->set_var('open_sg', $sg);
        $t->set_block('main','tab','sg_contents');
        $t->set_block('tab', 'notes', 'tab_notes');

        $ext_info = $this->_get_extended($sg, $grp);
        $tab_li = '<ul>';
        foreach ($ext_info as $tab => $params) {
            $tab_contents = '';
            $current_fs = '';
            $fs_flag = false;
            $table_flag = false;
            foreach ($params as $name => $e) {
                if ($e['type'] == 'fieldset' AND $e['fieldset'] != $current_fs) {
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
                        $this->_UI_get_conf_element_2($grp, $name,
                                                   $e['display_name'],
                                                   $e['type'],
                                                   $e['value'],
                                                   $e['selectionArray'], false,
                                                   $e['reset']);
                } else {
                    $tab_contents .=
                        $this->_UI_get_conf_element($grp, $name,
                                                   $e['display_name'],
                                                   $e['type'],
                                                   $e['value'],
                                                   $e['selectionArray'], false,
                                                   $e['reset']);
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
            if ( !SEC_inGroup('Root') && !SEC_hasRights($tab_name) ) {
                continue;
            }
            // tab content
            $tab_display = $this->_UI_get_tab($grp, $tab_contents, $tab, $t);
            
            // tab list
            $tab_li .= '<li><a href="#tab-' . $tab . '">' . $tab_display . '</a></li>';
        }
        $tab_li .= '</ul>';
        $t->set_var('tab_li', $tab_li);
        
        $_SCRIPTS->setJavaScriptLibrary('jquery.ui.autocomplete');
        $_SCRIPTS->setJavaScriptLibrary('jquery.ui.tabs');
        
        $t->set_var('config_menu',$this->_UI_configmanager_menu($grp,$sg));
        
        // message box
        if ($change_result != null AND $change_result !== array()) {
            $t->set_var('lang_changes_made', $LANG_CONFIG['changes_made'] . ':');
            $t->set_var('change_block',$this->_UI_get_change_block($change_result, $grp, $sg));
        } else {
            $t->set_var('show_changeblock','none');
        }
        if ( !empty($this->validationErrors) ) {
            $t->set_var('lang_changes_made', '');
            $t->set_var('show_changeblock', '');
            $t->set_var('change_block',$this->_UI_get_change_block(NULL, $grp, $sg));
            $t->set_var('lang_error_validation_occurs', $LANG_CONFIG['error_validation_occurs'] . ' :');
            $t->set_var('error_validation_class', ' error_validation');
        }
        
        $display = $t->finish($t->parse("OUTPUT", "main"));
        $display = COM_createHTMLDocument($display, array('what' => 'none', 'pagetitle' => $LANG_CONFIG['title'], 'rightblock' => false));

        return $display;
    }

    /**
     * Get messages to display when changes were made to the configuration.
     * 
     * @param  array  $changes Array of changes. Keys are configuration
     *                         paramater name.
     * @param  string $group   Configuration group
     * @param  int    $sg      Configuration subgroup
     * @return string          string of HTML to be displayed on message box 
     */
    function _UI_get_change_block($changes, $group = null, $sg = null)
    {
        $display = '';
        $anchors = array();
        
        if ( empty($this->validationErrors) ) {
            if ($changes != null AND $changes !== array()) {
                foreach ($changes as $param_name => $success) {
                    if ( isset($this->changedArray[$group][$param_name]) ) {
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
            foreach ( $this->validationErrors as $grp => $errors ) {
                foreach ( $errors as $param_name => $error ) {
                    $anchors[] = ' <a href="#' . $param_name . '" class="select_config"' .
                                 (($group !== null) ? ' group="' . $group . '"' : '') .
                                 (($sg !== null) ? ' subgroup="' . $sg . '"' : '') .
                                 '>' . $param_name . '</a>';
                }
            }
        }
        
        if ( !empty($anchors) ) {
            $display = implode(',', $anchors);
        }
        
        return $display;
    }
    
    /**
     * Set tab from configuration where tab = $tab_id under the group $group
     * with content $contents to template $t
     * 
     * @param  string $group Configuration group
     * @param  string $contents Contents
     * @param  int    $tab_id tab id
     * @param  object $t        Template object
     * @return string tab name to display based on current language
     */
    function _UI_get_tab($group, $contents, $tab_id, &$t)
    {
        global $_TABLES, $LANG_tab, $LANG_CONFIG;
        
        if (!array_key_exists($group, $LANG_tab)) {
            $LANG_tab[$group] = array();
        }
        $t->set_var('tab_contents', $contents);
        $tab_index = DB_getItem($_TABLES['conf_values'], 'name',
                        "type = 'tab' AND tab = $tab_id AND group_name = '$group'");
        $tab_display = '';
        if (empty($tab_index)) {
            if (empty($LANG_tab[$group][$tab_id])) {
               $tab_display = $LANG_CONFIG['default_tab_name'];
            } else {
                $tab_display = $LANG_tab[$group][$tab_id];
            }
        } else if (isset($LANG_tab[$group][$tab_index])) {
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
     * @param  string $group
     * @param  string $contents Contents
     * @param  int    $fs_id
     * @param  object $t        Template object
     * @return void
     */
    function _UI_get_fs($group, $contents, $fs_id, &$t)
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
        } else if (isset($LANG_fs[$group][$fs_index])) {
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
    function _UI_perm_denied()
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
     * @param  string $group Configuration group.
     * @param  string $name Configuration name on table.
     * @param  string $display_name Configuration display name based on language.
     * @param  string $type Configuration type such as select, text, textarea, @select, etc.
     * @param  string $val Value of configuration
     * @param  mixed  $selectionArray Array of option of select element
     * @param  bool   $deleteable If configuration is deleteable
     * @param  bool   $allow_reset Allow set and unset of configuration
     * @return
     */
    function _UI_get_conf_element($group, $name, $display_name, $type, $val,
                                  $selectionArray = null , $deletable = false,
                                  $allow_reset = false)
    {
        global $_CONF, $LANG_CONFIG;

        $t = COM_newTemplate($GLOBALS['_CONF']['path_layout'] . 'admin/config');
        $t -> set_file('element', 'config_element.thtml');

        $blocks = array('delete-button', 'text-element', 'placeholder-element',
                        'select-element', 'list-element', 'unset-param',
                        'keyed-add-button', 'unkeyed-add-button', 'text-area',
                        'validation_error_block');
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
        if ( isset($this->tmpValues[$group][$name]) ) {
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
        if ( isset($this->validationErrors[$group][$name]) ) {
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
            if (($a = strrchr($name, '[')) !== FALSE) {
                $on = substr($a, 1, -1);
                $o = str_replace(array('[', ']'), array('_', ''), $name);
            } else {
                $o = $name;
                $on = $name;
            }
            if (! is_numeric($on)) {
                $this->_set_ConfigHelp($t, $group, $o);
            }
        }
        if ($type == "unset") {
            return $t->finish($t->parse('output', 'unset-param'));
        } elseif ($type == "text") {
            return $t->finish($t->parse('output', 'text-element'));
        } elseif ($type == "textarea") {
            return $t->finish($t->parse('output', 'text-area'));
        } elseif ($type == "placeholder") {
            return $t->finish($t->parse('output', 'placeholder-element'));
        } elseif ($type == 'select') {
            // if $name is like "blah[0]", separate name and index
            $n = explode('[', $name);
            $name = $n[0];
            $index = null;
            if (count($n) == 2) {
                $i = explode(']', $n[1]);
                $index = $i[0];
            }
            $type_name = $type . '_' . $name;
            if ($group == 'Core') {
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
            } else if (is_array($selectionArray)) {
                // leave sorting to the function otherwise
                uksort($selectionArray, 'strcasecmp');
            }
            if (! is_array($selectionArray)) {
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
            if ($index == 'placeholder') {
                $t->set_var('hide_row', ' style="display:none;"');
            }
            return $t->parse('output', 'select-element');
        } elseif (strpos($type, '@') === 0) {
            $result = '';
            foreach ($val as $valkey => $valval) {
                $result .= config::_UI_get_conf_element($group,
                                $name . '[' . $valkey . ']',
                                $display_name . '[' . $valkey . ']',
                                substr($type, 1), $valval, $selectionArray,
                                false);
            }
            return $result;
        } elseif (strpos($type, "*") === 0 || strpos($type, "%") === 0) {
            $t->set_var('arr_name', $name);
            $t->set_var('array_type', $type);
            $button = $t->parse('output', (strpos($type, "*") === 0 ?
                                           'keyed-add-button' :
                                           'unkeyed-add-button'));
            $t->set_var('my_add_element_button', $button);
            $result = "";
            if ($type == '%select') {
                $result .= config::_UI_get_conf_element($group,
                                $name . '[placeholder]', 'placeholder',
                                substr($type, 1), 'placeholder', $selectionArray,
                                true);
            }
            foreach ($val as $valkey => $valval) {
                $result .= config::_UI_get_conf_element($group,
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
     * @param  string $group Configuration group.
     * @param  string $name Configuration name on table.
     * @param  string $display_name Configuration display name based on language.
     * @param  string $type Configuration type such as select, text, textarea, @select, etc.
     * @param  string $val Value of configuration
     * @param  mixed  $selectionArray Array of option of select element
     * @param  bool   $deleteable If configuration is deleteable
     * @param  bool   $allow_reset Allow set and unset of configuration
     * @return
     */
    function _UI_get_conf_element_2($group, $name, $display_name, $type, $val,
                                  $selectionArray = null , $deletable = false,
                                  $allow_reset = false)
    {
        global $_CONF, $LANG_CONFIG;

        $t = COM_newTemplate($GLOBALS['_CONF']['path_layout'] . 'admin/config');
        $t -> set_file('element', 'config_element_2.thtml');

        $blocks = array('delete-button', 'text-element', 'placeholder-element',
                        'select-element', 'list-element', 'unset-param',
                        'keyed-add-button', 'unkeyed-add-button', 'text-area',
                        'validation_error_block');
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
        if ( isset($this->tmpValues[$group][$name]) ) {
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
        if ( isset($this->validationErrors[$group][$name]) ) {
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
            if (($a = strrchr($name, '[')) !== FALSE) {
                $on = substr($a, 1, -1);
                $o = str_replace(array('[', ']'), array('_', ''), $name);
            } else {
                $o = $name;
                $on = $name;
            }
            if (! is_numeric($on)) {
                $this->_set_ConfigHelp($t, $group, $o);
            }
        }
        // if $name is like "blah[0]", separate name and index
        $n = explode('[', $name);
        $index = null;
        $nc = count($n);
        if ($nc > 1) {
            $i = explode(']', $n[$nc-1]);
            $index = $i[0];
        }
        if (!empty($index) && ($index == 'placeholder' || $display_name == 'skeleton')) {
            $t->set_var('hide_row', ' style="display:none;"');
        }

        $prefix = substr($type, 0, 1);
        if ($type == "unset") {
            return $t->finish($t->parse('output', 'unset-param'));
        } elseif ($type == "text") {
            return $t->finish($t->parse('output', 'text-element'));
        } elseif ($type == "textarea") {
            return $t->finish($t->parse('output', 'text-area'));
        } elseif ($type == "placeholder") {
            return $t->finish($t->parse('output', 'placeholder-element'));
        } elseif ($type == 'select') {

            // if $name is like "blah[0]", separate name and index
            $n = explode('[', $name);
            $name = $n[0];
            $type_name = $type . '_' . $name;
            if ($group == 'Core') {
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
            } else if (is_array($selectionArray)) {
                // leave sorting to the function otherwise
                uksort($selectionArray, 'strcasecmp');
            }
            if (! is_array($selectionArray)) {
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
        } elseif ($prefix == '@') {
            $result = '';
            foreach ($val as $valkey => $valval) {
                $result .= config::_UI_get_conf_element_2($group,
                                $name . '[' . $valkey . ']',
                                $display_name . '[' . $valkey . ']',
                                substr($type, 1), $valval, $selectionArray,
                                false);
            }
            return $result;
        } elseif ($prefix == '*' || $prefix == '%') {
            $t->set_var('arr_name', $name);
            $t->set_var('array_type', $type);
            $button = $t->parse('output', ($prefix == '*' ?
                                           'keyed-add-button' :
                                           'unkeyed-add-button'));
            $t->set_var('my_add_element_button', $button);
            $result = "";

            $base_type = str_replace(array('*', '%'), '', $type);
            if (in_array($base_type, array('select', 'text', 'placeholder'))) {
                $result .= config::_UI_get_conf_element_2($group,
                                $name . '[placeholder]', 'skeleton',
                                substr($type, 1), 'placeholder', $selectionArray,
                                true);
            }

            if ($display_name == 'skeleton') {
                $val = array();
            }
            if (!is_array($val)) {
                $val = array();
            }

            foreach ($val as $valkey => $valval) {
                $result .= config::_UI_get_conf_element_2($group,
                                $name . '[' . $valkey . ']', $valkey,
                                substr($type, 1), $valval, $selectionArray,
                                true);
            }
            $t->set_var('my_elements', $result);
            // if the values are indexed numerically, add a class to the div
            // for identification. The UI code can take advantage of it
            $t->set_var('arr_class_list', ($prefix == '%' ?
                                           'numerical_config_list' :
                                           'named_config_list'));
            return $t->parse('output', 'list-element');
        }
    }

    /**
     * This function takes $_POST input and evaluates it
     *
     * @param  array(string=>mixed)      $change_array this is the $_POST array
     * @param  string                    $group Group name
     * @return array(string=>boolean)    this is the change_array
     */
    function updateConfig($change_array, $group)
    {
        global $_TABLES;
        
        require_once 'validator.class.php';

        if ($group == 'Core') {
            /**
             * $_CONF['theme'] and $_CONF['language'] are overwritten with
             * the user's preferences in lib-common.php. Re-read values from
             * the database so that we're comparing the correct values below.
             */
            $value = DB_getItem($_TABLES['conf_values'], 'value',
                                "group_name='Core' AND name='theme'");
            $this->config_array['Core']['theme'] = unserialize($value);
            $value = DB_getItem($_TABLES['conf_values'], 'value',
                                "group_name='Core' AND name='language'");
            $this->config_array['Core']['language'] = unserialize($value);

            /**
             * Same with $_CONF['cookiedomain'], which is overwritten in
             * in lib-sessions.php (if empty).
             */
            $value = DB_getItem($_TABLES['conf_values'], 'value',
                                "group_name='Core' AND name='cookiedomain'");
            $this->config_array['Core']['cookiedomain'] = unserialize($value);
        }
        
        $this->_extract_permissible_conf($change_array, $group, $change_array['sub_group']);
        
        $pass_validation = array();
        $success_array = array();
        if (!is_array($this->validationErrors)) {
          $this->validationErrors = array();
        }
        
        foreach ($this->config_array[$group] as $param_name => $param_value) {
            if (array_key_exists($param_name, $change_array)) {
                $change_array[$param_name] =
                    $this->_validate_input($param_name, $group, $change_array[$param_name]);
                
                // we should avoid string conversion
                // see http://www.php.net/manual/en/language.types.string.php#language.types.string.conversion
                if ( is_string($change_array[$param_name]) && 
                     !is_string($param_value) )
                {
                    if (strcmp($change_array[$param_name], $param_value) !== 0 &&
                        $this->_validates($param_name, $group, $change_array[$param_name]))
                    {
                        $pass_validation[$param_name] = $change_array[$param_name];
                    }
                } else if ( is_array($change_array[$param_name]) ) {
                    /* if array such as mail settings */
                    $_changed = false;
                    if (count($this->config_array[$group][$param_name]) !=  count($change_array[$param_name])) {
                        $_changed = true;
                    }
                    foreach ( $change_array[$param_name] as $_param_name => $_param_value ) {
                         if (!isset($this->config_array[$group][$param_name][$_param_name])) {
                             $_changed = true;
                         } elseif ( $change_array[$param_name][$_param_name] != $this->config_array[$group][$param_name][$_param_name] ) {
                             $_changed = true;
                         }
                         if ($_changed) {
                             if ( $this->_validates($param_name . '[' . $_param_name . ']', $group, $change_array[$param_name][$_param_name], $change_array[$param_name]) ) {
                                 $this->changedArray[$group][$param_name][$_param_name] = true;
                             }
                         }
                     }
                    
                    if ( $_changed ) {
                        $pass_validation[$param_name] = $change_array[$param_name];
                    }
                } else {
                    if ($change_array[$param_name] != $param_value &&
                        $this->_validates($param_name, $group, $change_array[$param_name]))
                    {
                        $pass_validation[$param_name] = $change_array[$param_name];
                    }
                }
            }
        }
        
        // after validation set the field
        if ( empty($this->validationErrors) ) {
            // only set if there is no validation error
            foreach ( $pass_validation as $param => $val ) {
                $this->set($param, $val, $group);
                $success_array[$param] = true;
            }
        } else {
            // temporaly save the changed values
            foreach ( $pass_validation as $param => $val ) {
                $this->tmpValues[$group][$param] = $val;
            }
        }
        
        return $success_array;
    }
    
    /**
     * Extracts allowed conf from posted data. Used by updateConfig
     * 
     * @param array(string=>mixed) $change_array this is the $_POST array
     * @param string $group Configuration group
     * @param int $sg_id Subgroup id
     */
    function _extract_permissible_conf(&$change_array, $group, $sg_id = null) {
        $permissible_conf = array();
        foreach ($this->conf_tab_arr[$group] as $sg => $tabs) {
            if ( $sg_id && $sg_id != $sg ) continue;
            
            foreach ($tabs as $tab_name => $tab) {
                foreach ($tab as $tab_id => $configs) {
                    $tab_ft = $this->conf_type['tab'][$group][$tab_name];
                    if ( SEC_inGroup('Root') || SEC_hasRights($tab_ft) ) {
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
     * @param mixed
     * @return mixed
     */
    function _validate_input($config, $group, &$input_val)
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
            if ($r == 'b:0' OR $r == 'b:1') {
                $r = ($r == 'b:1');
            } 
            //if (is_numeric($r)) {
            if (is_numeric($r) && $this->_validate_numeric($config, $group)) {
                $r = $r + 0;
            }
        }

        return $r;
    }
    
    /**
     * Returns true if configuration field should be numeric.
     * 
     * @param string $config Configuration variable
     * @param string $group Configuration group
     * @return boolean True if numeric
     * @access public
     */
    function _validate_numeric($config, $group) {
        global $_CONF_VALIDATE; 
        
        if ( isset($_CONF_VALIDATE[$group][$config]) &&
             !empty($_CONF_VALIDATE[$group][$config]) )
        {        
            foreach ($_CONF_VALIDATE[$group][$config] as $index => $validator) {
                if ($index == 'rule') {
                    if (is_array($validator)) {
                        $rule_type = $validator[0];
                    } else {
                        $rule_type = $validator;
                    }
                    if (in_array($rule_type, array( 'numeric', 'range', 'decimal', 'comparison'))) {
                        return true;
                    } else {
                        return false;
                    }                    
                }
            }
        }
        
        // No rule found then return true as validation will happen the old way by just using is_numeric
        return true;
    }
    
    /**
     * Returns true if configuration field pass given validation rule.
     * 
     * @param string $config Configuration variable
     * @param string $group Configuration group
     * @param mixed $value Submitted value
     * @param mixed $relatedValue value that related such as mail settings
     * @return boolean True if there are no errors
     * @access public
     */
    function _validates($config, $group, &$value, &$relatedValue = null) {
        global $_CONF_VALIDATE, $LANG_VALIDATION;
        
        $_validator =& validator::getInstance();
        
        if ( isset($_CONF_VALIDATE[$group][$config]) &&
             !empty($_CONF_VALIDATE[$group][$config]) )
        {
            $default = array(
                'rule' => 'blank'
            );
            
            foreach ($_CONF_VALIDATE[$group][$config] as $index => $validator) {
                if (!is_array($validator)) {
                    if ( $index == 'message' && is_string($validator) ) continue;
                    
                    $validator = array('rule' => $validator);
                } else {
                    if ( $index == 'rule' ) {
                        $validator = array('rule' => $validator);
                    }
                }
                if ( isset($_CONF_VALIDATE[$group][$config]['message']) && 
                     is_string($_CONF_VALIDATE[$group][$config]['message']) ) 
                {
                    $validator['message'] = $_CONF_VALIDATE[$group][$config]['message'];
                    unset($_CONF_VALIDATE[$group][$config]['message']);
                }
                $validator = array_merge($default, $validator);
                
                if (isset($validator['message'])) {
                    $message = $validator['message'];
                } else if ( is_string($validator['rule']) && isset($LANG_VALIDATION[$validator['rule']]) ) {
                    $message = $LANG_VALIDATION[$validator['rule']];
                } else if ( is_array($validator['rule']) && isset($LANG_VALIDATION[$validator['rule'][0]]) ) {
                    $message = $LANG_VALIDATION[$validator['rule'][0]];
                } else {
                    $message = $LANG_VALIDATION['default'];
                }
                
                if ( is_array($validator['rule']) ) {
                    $rule = $validator['rule'][0];
                    unset($validator['rule'][0]);
                    $ruleParams = array_merge(array($value), array_values($validator['rule']));
                } else {
                    $rule = $validator['rule'];
                    $ruleParams = array($value);
                }
                
                $valid = true;
                $custom_function = 'custom_validation_' . strtolower($rule);
                if ( function_exists($custom_function) ) {
                    $ruleParams[] = $validator;
                    $ruleParams[0] = array($config => $ruleParams[0]);
                    
                    if ( is_array($relatedValue) && !empty($relatedValue) ) {
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
                    
                    return FALSE;
                }
            } // end foreach
            return $valid;
        } // end if
        
        return TRUE;
    }

    /**
     * Builds configuration menu
     * 
     * @param $conf_group Configuration group
     * @param $sg Configuration subgroup
     */
    function _UI_configmanager_menu($conf_group,$sg=0)
    {
        global $_CONF, $LANG_ADMIN, $LANG_CONFIG,
               $LANG_configsections, $LANG_configsubgroups;

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
                if ($group == 'Core') {
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
        $retval .= COM_endBlock(COM_getBlockTemplate('configmanager_block',
                                                     'footer'));


        /* Now display the sub-group menu for the selected config group */
        if (empty($LANG_configsections[$conf_group]['title'])) {
            $subgroup_title = ucwords($conf_group);
        } else {
            $subgroup_title = $LANG_configsections[$conf_group]['title'];
        }
        $retval .= COM_startBlock($subgroup_title, '',
                    COM_getBlockTemplate('configmanager_subblock', 'header'));

        $sgroups = $this->_get_sgroups($conf_group);
        if (count($sgroups) > 0) {
            $i = 0;
            foreach ($sgroups as $sgname => $sgroup) {
                if (isset($LANG_configsubgroups[$conf_group][$sgname])) {
                    $group_display = $LANG_configsubgroups[$conf_group][$sgname];
                } else if (isset($LANG_configsubgroups[$conf_group][$sgroup])) {
                    $group_display = $LANG_configsubgroups[$conf_group][$sgroup];
                } else {
                    $group_display = $sgname;
                }
                // Create a menu item for each sub config group - disable the link for the current selected one
                if ($this->flag_version_2 == true) {
                    if ($sgroup == $sg) {
                        $retval .= "<li class=\"configoption_off\">$group_display</li>";
                    } else {
                        $retval .= "<li class=\"configoption\"><a href=\"#\" onclick='open_subgroup(\"$conf_group\",\"$sgroup\");return false;'>$group_display</a></li>";
                    }
                } else {
                    if ($sgroup == $sg) {
                        $retval .= "<div>$group_display</div>";
                    } else {
                        $retval .= "<div><a href=\"#\" onclick='open_subgroup(\"$conf_group\",\"$sgroup\");return false;'>$group_display</a></div>";
                    }
                }
                $i++;
            }
        }
        $retval .= COM_endBlock(COM_getBlockTemplate('configmanager_block',
                                                     'footer'));

        return $retval;
    }
    
    /**
     * Build JSON for autocomplete
     * @return string JS variable in string
     */
    function _UI_autocomplete_data() {
        global $_CONF, $LANG_configsections, $LANG_confignames, $LANG_fs, $LANG_tab, $LANG_CONFIG;
        
        $permitted_groups = $this->_get_groups();
        $retval = array();
        
        foreach ($this->conf_type['tree'] as $group => $subgroups) {
            if ( !in_array($group, $permitted_groups) ) {
                continue;
            }
            
            foreach ($subgroups as $sg => $tabs) {
                foreach ($tabs as $tab => $tab_ft) {
                    if ( !SEC_inGroup('Root') && !SEC_hasRights($tab_ft) ) {
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
                                    // No label found, set name
                                    $label = $conf;
                                }
                            }
                            
                            if ( is_array($conf_var) ) {
                                foreach ( $conf_var as $_conf_var ) {
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
                                        str_replace('"', '\"', $LANG_configsections[$group]['label']) .' &raquo; ' .
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
     * @return string JS variable in string
     */
    function _UI_js_image_spinner() {
        $image = $GLOBALS['_CONF']['layout_url'] . '/jquery_ui/images/ui-anim_basic_16x16.gif';
        
        return 'var imgSpinner = "' . $image . '";';
    }

    /**
     * Helper function: Fix escaped SQL requests for MS SQL, if necessary
     *
     */
    function _DB_escapedQuery($sql)
    {
        global $_DB, $_DB_dbms;

        if ($_DB_dbms == 'mssql') {
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
    * @param    string  $t          Template
    * @param    string  $group      'Core' or plugin name
    * @param    string  $option     name of the config option
    *
    */
    function _set_ConfigHelp(&$t, $group, $option)
    {
        global $_SCRIPTS;
        static $docUrl;

        if (!isset($docUrl)) {
            $docUrl = array();
        }

        $retval = '';

        $configtext = PLG_getConfigTooltip($group, $option);
        if (empty($configtext)) {
            if ($group == 'Core') {
                $configtext = NULL;
            }
            if (empty($docUrl[$group])) {
                if ($group == 'Core') {
                    if (!empty($GLOBALS['_CONF']['site_url']) &&
                            !empty($GLOBALS['_CONF']['path_html'])) {
                        $baseUrl = $GLOBALS['_CONF']['site_url'];
                        $doclang = COM_getLanguageName();
                        $cfg = 'docs/' . $doclang . '/config.html';
                        if (file_exists($GLOBALS['_CONF']['path_html'] . $cfg)) {
                            $url = $baseUrl . '/' . $cfg;
                        } else {
                            $url = $baseUrl . '/docs/english/config.html';
                        }
                    } else {
                        $url = 'http://www.geeklog.net/docs/english/config.html';
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
                    if (gettype($configtext) == "NULL") {
                        $t->set_var('doc_link',
                                '(<a href="javascript:void(0);" id="desc_' . $option . '" class="tooltip">?</a>)');
                    } else {
                        $t->set_var('doc_link',
                                '(<a href="javascript:void(0);" id="desc_' . $option . '">?</a>)');
                    }
                } else {
                    // Does hack need to be used?
                    if (gettype($configtext) == "NULL") {
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
            $retval = "(" . COM_getTooltip("?", $configtext, '', $option,'information') . ")";
            $t->set_var('doc_link', $retval);            
        }

    }
    
    /**
     * Get features that has ft_name like 'config%'.
     * Used by lib-common to declare $_CONF_FT
     * @return array features that has ft_name like 'config%'
     */
    function _get_config_features() {
        global $_TABLES;
        
        if ( is_null($this->conf_ft_arr) ) {
            $result = DB_query("SELECT ft_name FROM {$_TABLES['features']} WHERE ft_name LIKE 'config.%'");
            $this->conf_ft_arr = array();
            $nrows = DB_numRows($result);
            if ($nrows > 0) {
                for ($i = 0; $i < $nrows; $i++) {
                    $A = DB_fetchArray($result, false);
                    $this->conf_ft_arr[$i] = $A['ft_name'];
                }
            }
        }
        
        return $this->conf_ft_arr;
    }
    
    
}

?>
