<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.5                                                               |
// +---------------------------------------------------------------------------+
// | config.class.php                                                          |
// |                                                                           |
// | Controls the UI and database for configuration settings                   |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007 by the following authors:                              |
// |                                                                           |
// | Authors: Aaron Blankstein  - kantai AT gmail DOT com                      |
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
//
// $Id: config.class.php,v 1.5 2007/10/12 03:33:08 ospiess Exp $

class config {
    var $ref;
    var $dbconfig_file;
    var $config_array;

    /**
     * This function will return an instance of the config class. If an
     * instance with the given group/reference name does not exist, then it
     * will create a new one. This function insures    that there is only one
     * instance for a given group name.
     *
     *    @param string group_name   This is simply the group name that this
     *                             config object will control - for the main gl
     *                             settings this is 'Core'
     *
     *    @return config                The newly created or referenced config object
     */
    function &get_instance()
    {
        static $instance;
        return $instance;
    }

    function create($ref = 'Core', $obj = null)
    {
        $instance =& config::get_instance();
        if ($instance[$ref] === null) {
            $instance[$ref] = ($obj === null ? new config($ref) : $obj);
        }
        return $instance[$ref];
    }

    function config($ref)
    {
        $this->ref = $ref;
    }

    /**
     * This function sets the secure configuration file (database related
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
     * This function reads the secure configuration file and loads
     * lib-database.php. This needs to be called in the 'Core' group before
     * &init_config() can be used. It only needs to be called once
     */

    function load_baseconfig()
    {
        if ($this->ref == 'Core') {
            global $_DB, $_TABLES, $_CONF;
            include($this->dbconfig_file);
            $this->config_array =& $_CONF;
            include_once($_CONF['path_system'] . 'lib-database.php' );
        }
    }

    /**
     * This function initializes the configuration array (i.e. $_CONF) and
     * will return a reference to the newly created array. The class keeps
     * track of this reference, and the set function will mutate it.
     *
     * @return array(string => mixed)      This is a reference to the
     *                              config array
     */
    function &initConfig()
    {
        global $_TABLES;
        $sql_query = "SELECT name, value FROM {$_TABLES['conf_values']} WHERE " .
            "group_name = '{$this->ref}'";
        $result = DB_query($sql_query);
        while ($row = DB_fetchArray($result)) {
            if ($row[1] !== 'unset')
                $this->config_array[$row[0]] = unserialize($row[1]);
        }
        if ($this->ref == 'Core')
            $this->_post_configuration();
        return $this->config_array;
    }

    /**
     * This function sets a configuration variable to a value in the database
     * and in the current array. If the variable does not already exist,
     * nothing will happen.
     *
     * @param string name        Name of the config parameter to set
     * @param mixed value        The value to set the config parameter to
     */
    function set($name, $value)
    {
        global $_TABLES, $_DB, $_DB_dbms;
        $escaped_val = addslashes(serialize($value));
        $escaped_name = addslashes($name);
        $sql_query = "UPDATE {$_TABLES['conf_values']} " .
            "SET value = '{$escaped_val}' WHERE " .
            "name = '{$escaped_name}' AND group_name = '{$this->ref}'";
        if ($_DB_dbms == 'mssql') {
            $sql_query = str_replace("\\'","''",$sql_query);
            $sql_query = str_replace('\\"','"',$sql_query);
            $_DB->dbQuery($sql_query, 0, 1);
        } else {
            DB_query($sql_query);
        }
        $this->config_array[$name] = $value;
        if ($this->ref == 'Core')
            $this->_post_configuration();
    }

    function restore_param($name)
    {
        global $_TABLES;
        $escaped_name = addslashes($name);
        $sql = "UPDATE {$_TABLES['conf_values']} SET value = default_value " .
            "WHERE name = '{$escaped_name}' AND group_name = '{$this->ref}'";
        DB_query($sql);
    }

    function unset_param($name)
    {
        global $_TABLES;
        $escaped_name = addslashes($name);
        $sql = "UPDATE {$_TABLES['conf_values']} SET value = 'unset' " .
            "WHERE name = '{$escaped_name}' AND group_name = '{$this->ref}'";
        DB_query($sql);
    }

    /**
     * Adds a configuration variable to the config object
     *
     * @param string $param_name        name of the parameter to add
     * @param mixed  $default_value     the default value of the parameter
     *                                  (also will be the initial value)
     * @param string $display_name      name that will be displayed on the
     *                                  user interface
     * @param string $type              the type of the configuration variable
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
     * @param string $subgroup          subgroup of the variable
     *                                  (the second row of tabs on the user interface)
     * @param string $fieldset          the fieldset to display the variable under
     * @param array  $selection_array   possible selections for the 'select' type
     *                                  this MUST be passed if you use the 'select'
     *                                  type
     * @param int    $sort              sort rank on the user interface (ascending)
     *
     * @param boolean $set              whether or not this parameter is set
     */
    function add($param_name, $default_value, $type, $subgroup, $fieldset,
         $selection_array=null, $sort=0, $set=true)
    {
        global $_TABLES, $_DB, $_DB_dbms;
        $format = 'INSERT INTO %1$s (name, value, type, ' .
            'subgroup, group_name, selectionArray, sort_order,'.
            ' fieldset, default_value) ' .
            'VALUES ("%2$s","%3$s","%4$s",%5$s,"%6$s",%7$s,'.
            '%8$s,%9$s, "%10$s")';
        $Qargs = array($_TABLES['conf_values'],
                       $param_name,
                       $set ? serialize($default_value) : 'unset',
                       $type,
                       $subgroup,
                       $this->ref,
                       ($selection_array === null ?
                        -1 : $selection_array),
                       $sort,
                       $fieldset,
                       serialize($default_value));
        $Qargs = array_map('addslashes', $Qargs);
        $sql_query = vsprintf($format, $Qargs);

        if ($_DB_dbms == 'mssql') {
            $sql_query = str_replace("\\'","''",$sql_query);
            $sql_query = str_replace('\\"','"',$sql_query);
            $_DB->dbQuery($sql_query, 0, 1);
        } else {
            DB_query($sql_query);
        }

        $this->config_array[$param_name] = $default_value;
    }

    /**
     * Permanently deletes a parameter
     * @param string  $param_name   This is the name of the parameter to delete
     */
    function del($param_name)
    {
        DB_delete($GLOBALS['_TABLES']['conf_values'],
                  array("name","group_name"),
                  array(addslashes($param_name), addslashes($this->ref)));
        unset($this->config_array[$param_name]);
    }

    /**
     * Gets extended (GUI related) information from the database
     * @param string subgroup            filters by subgroup
     * @return array(string => string => array(string => mixed))
     *    Array keys are fieldset => parameter named => information array
     */
    function _get_extended($subgroup)
    {
        global $_TABLES, $LANG_coreconfignames, $LANG_coreconfigselects;
        $q_string = "SELECT name, type, selectionArray, "
            . "fieldset, value FROM {$_TABLES['conf_values']}" .
            " WHERE group_name='{$this->ref}' and subgroup='{$subgroup}' " .
            " ORDER BY sort_order ASC";
        $Qresult = DB_query($q_string);
        $res = array();
        while ($row = DB_fetchArray($Qresult)) {
            $cur = $row;
            $res[$cur[3]][$cur[0]] =
                array('display_name' =>
                      (array_key_exists($cur[0], $LANG_coreconfignames) ?
                       $LANG_coreconfignames[$cur[0]]
                       : $cur[0]),
                      'type' =>
                      (($cur[4] == 'unset') ?
                       'unset' : $cur[1]),
                      'selectionArray' =>
                      (($cur[2] != -1) ?
                       $LANG_coreconfigselects[$cur[2]] : null),
                      'value' =>
                      (($cur[4] == 'unset') ?
                       'unset' : unserialize($cur[4])));
        }
        return $res;
    }

    /* Changes any config settings that depend on other configuration settings. */
    function _post_configuration()
    {
        $this->config_array['path_layout'] = $this->config_array['path_themes']
            . $this->config_array['theme'] . '/';
        $this->config_array['layout_url'] = $this->config_array['site_url']
            . '/layout/' . $this->config_array['theme'];
    }

    function _get_groups()
    {
        return array_keys(config::get_instance());
    }

    function get_sgroups()
    {
        global $_TABLES;
        $q_string = "SELECT subgroup FROM {$_TABLES['conf_values']} WHERE " .
            "group_name='{$this->ref}' " .
            "GROUP BY subgroup";
        $res = DB_query($q_string);
        $return = array();
        while ($row = DB_fetchArray($res))
            $return[] = $row[0];
        return $return;
    }

    /**
     * This function is responsible for creating the configuration GUI
     *
     * @param string sg        This is the subgroup name to load the gui for.
     *                        If nothing is passed, it will display the first
     *                         (alpha) subgroup
     *
     * @param array(string=>boolean) change_result
     *                        This is an array of what changes were made to the
     *                        configuration - if it is passed, it will display
     *                        the "Changes" message box.
     */
    function get_ui($sg=0, $change_result=null)
    {
        global $LANG_coreconfigsubgroups;
        if (!SEC_inGroup('Root'))
            return config::_UI_perm_denied();
        $t = new Template($GLOBALS['_CONF']['path_layout'] . 'admin/config');
        $t->set_file('main','configuration.thtml');
        $t->set_var('site_url',$GLOBALS['_CONF']['site_url']);
        $t->set_var('open_group', $this->ref);
        $t->set_block('main','group-selector','groups');
        $groups = config::_get_groups();
        foreach ($groups as $group) {
            $t->set_var("select_id", ($group === $this->ref ? 'id="current"' : ''));
            $t->set_var("group_select_value", $group);
            $t->set_var("group_display", ucwords($group));
            $t->parse("groups", "group-selector", true);
        }
        $subgroups = $this->get_sgroups();
        $t->set_block('main','subgroup-selector','navbar');
        foreach ($subgroups as $sgroup) {
            $t->set_var('select_id', ($sg === $sgroup ? 'id="current"' : ''));
            $t->set_var('subgroup_name', $sgroup);
            $t->set_var("subgroup_display_name",
                        $LANG_coreconfigsubgroups[$sgroup]);
            $t->parse("navbar", "subgroup-selector", true);
        }
        $t->set_var('open_sg', $sg);
        $t->set_block('main','fieldset','sg_contents');
        $t->set_block('fieldset', 'notes', 'fs_notes');
        $ext_info = $this->_get_extended($sg);
        foreach ($ext_info as $fset=>$params) {
            $fs_contents = '';
            foreach ($params as $name=>$e) {
                $fs_contents .=
                    config::_UI_get_conf_element($name,
                                               $e['display_name'],
                                               $e['type'],
                                               $e['value'],
                                               $e['selectionArray']);
            }
            config::_UI_get_fs($fs_contents, $fset, $t);
        }

        // Output the result.
        $display  = COM_siteHeader('menu');
        $display .= COM_startBlock('Configuration');
        $display .= config::_UI_get_change_block($change_result);
        $display .= $t->finish($t->parse("OUTPUT", "main"));
        $display .= COM_endBlock();
        $display .= COM_siteFooter(false);
        return $display;
    }

    function _UI_get_change_block($changes)
    {
        if ($changes != null AND $changes !== array()) {
            $display = COM_startBlock ('Results', '',
                                       COM_getBlockTemplate ('_msg_block', 'header'));
            $display .= '<p padding="5px">Changes were successfully made to:<ul>';
            foreach ($changes as $param_name => $success)
                $display .= '<li>' . $param_name . '</li>';
            $display .= '</ul></p>';
            $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
            return $display;
        }
    }

    function _UI_get_fs($contents, $fs_id, &$t)
    {
        global $LANG_fs;
        $t->set_var('fs_contents', $contents);
        $t->set_var('fs_display', $LANG_fs[$fs_id]);
        $t->set_var('fs_notes', '');
        $t->parse('sg_contents', 'fieldset', true);
    }

    function _UI_perm_denied()
    {
        $display = COM_siteHeader ('menu');
        $display .= COM_startBlock ('Permission denied.', '',
                                    COM_getBlockTemplate ('_msg_block', 'header'));
        $display .= '<p padding="5px">You do not have the necessary permissions'
            . ' to access this page.</p>';
        $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        $display .= COM_siteFooter ();
        COM_accessLog("User {$_USER['username']} tried to illegally" .
                      " access the config administration screen.");
        return $display;
    }

    function _UI_get_conf_element($name, $display_name, $type, $val,
                                          $selectionArray = null , $deletable=0)
    {
        $t = new Template($GLOBALS['_CONF']['path_layout'] . 'admin/config');
        $t -> set_file('element', 'config_element.thtml');

        $blocks = array('delete-button', 'text-element', 'placeholder-element',
                        'select-element', 'list-element', 'unset-param',
                        'keyed-add-button', 'unkeyed-add-button');
        foreach ($blocks as $block)
            $t->set_block('element', $block);

        $t->set_var('name', $name);
        $t->set_var('display_name', $display_name);
        $t->set_var('value', $val);
        if ($deletable)
            $t->set_var('delete', $t->parse('output', 'delete-button'));
        elseif ($this->ref == 'Core' ) {
            $t->set_var('unset_link',
                        "(<a href='#' onClick='unset(\"{$name}\");'>X</a>)");
            if (($a = strrchr($name, '[')) !== FALSE) {
                $o = substr($a, 1, -1);
            } else {
                $o = $name;
            }
            if (! is_numeric($o)) {
                if (!empty($GLOBALS['_CONF']['site_url'])) {
                    $baseUrl = $GLOBALS['_CONF']['site_url'];
                } else {
                    $baseUrl = 'http://www.geeklog.net';
                }
                $t->set_var('doc_link',
                            '(<a href="' . $baseUrl . '/docs/config.html#desc_'
                            . $o . '" target="help">?</a>)');
            }
        }
        if ($type == "unset") {
            return $t->finish($t->parse('output', 'unset-param'));
        } elseif ($type == "text") {
            return $t->finish($t->parse('output', 'text-element'));
        } elseif ($type == "placeholder") {
            return $t->finish($t->parse('output', 'placeholder-element'));
        } elseif ($type == "select") {
            if (! is_array($selectionArray))
                return $t->finish($t->parse('output', 'text-element'));
            $t->set_block('select-element', 'select-options', 'myoptions');
            foreach ($selectionArray as $sName => $sVal) {
                if (is_bool($sVal)) {
                    $t->set_var('opt_value', $sVal ? 'b:1' : 'b:0');
                } else {
                    $t->set_var('opt_value', $sVal);
                }
                $t->set_var('opt_name', $sName);
                $t->set_var('selected', ($val == $sVal ? 'SELECTED' : ''));
                $t->parse('myoptions', 'select-options', true);
            }
            return $t->parse('output', 'select-element');
        } elseif (strpos($type, "@") === 0) {
            $result = "";
            foreach ($val as $valkey => $valval) {
                $result .= config::_UI_get_conf_element($name . '[' . $valkey . ']',
                                                      $display_name . '[' . $valkey . ']',
                                                      substr($type, 1), $valval, $selectionArray);
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
            foreach ($val as $valkey => $valval) {
                $result .= config::_UI_get_conf_element($name . '[' . $valkey . ']', $valkey,
                                                      substr($type, 1), $valval, $selectionArray, true);
            }
            $t->set_var('my_elements', $result);
            return $t->parse('output', 'list-element');
        }
    }

    /**
     * This function takes $_POST input and evaluates it
     *
     * param array(string=>mixed)       $change_array this is the $_POST array
     * return array(string=>boolean)    this is the change_array
     */
    function updateConfig($change_array)
    {
        if (!SEC_inGroup('Root')) {
            return null;
        }
        $success_array = array();
        foreach ($this->config_array as $param_name => $param_value) {
            if (array_key_exists($param_name, $change_array)) {
                $change_array[$param_name] =
                    $this->_validate_input($change_array[$param_name]);
                if ($change_array[$param_name] != $param_value) {
                    $this->set($param_name, $change_array[$param_name]);
                    $success_array[$param_name] = true;
                }
            }
        }
        return $success_array;
    }

    function _validate_input(&$input_val)
    {
        if (is_array($input_val)) {
            $r = array();
            foreach ($input_val as $key => $val) {
                if ($key !== 'placeholder') {
                    $r[$key] = $this->_validate_input($val);
                }
            }
        } else {
            $r = COM_stripSlashes( $input_val );
            if ($r == 'b:0' OR $r == 'b:1') {
                $r = ($r == 'b:1');
            }
            if (is_numeric($r)) {
                $r = $r + 0;
            }
        }
        return $r;
    }
}

?>
